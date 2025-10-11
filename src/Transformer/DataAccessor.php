<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

readonly class DataAccessor implements AccessorInterface
{
    protected PropertyAccessorInterface $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param array<int|string, mixed>|object $from
     */
    public function get(array|object $from, string $path): mixed
    {
        $segs = $this->tokens($path);

        if ([] === $segs) {
            return null;
        }

        $current = $from;

        foreach ($segs as $seg) {
            if (\is_array($current)) {
                $key = $this->castArrayKey($seg);

                if (!\array_key_exists($key, $current)) {
                    return null;
                }

                $current = $current[$key];

                continue;
            }

            if ($current instanceof \ArrayAccess) {
                $key = $this->castArrayKey($seg);

                if (!$current->offsetExists($key)) {
                    return null;
                }

                $current = $current[$key];

                continue;
            }

            if (\is_object($current)) {
                try {
                    $current = $this->propertyAccessor->getValue($current, $seg);
                } catch (\Throwable) {
                    // TODO: Log error
                    return null;
                }

                continue;
            }

            return null;
        }

        return $current;
    }

    /**
     * @param array<int|string, mixed>|object $into
     */
    public function set(array|object &$into, string $path, mixed $value): void
    {
        $segs = $this->tokens($path);

        if ([] === $segs) {
            return;
        }

        /* @var non-empty-list<string> $segs */
        $this->doSet($into, $segs, $value);
    }

    /**
     * @param array<int|string, mixed>|object $current
     * @param non-empty-list<string> $segs
     */
    protected function doSet(array|object &$current, array $segs, mixed $value): void
    {
        $seg = \array_shift($segs);
        /** @var string $seg */
        $isLast = [] === $segs;

        if (\is_array($current)) {
            $key = $this->castArrayKey($seg);

            if ($isLast) {
                $current[$key] = $value;

                return;
            }

            if (!\array_key_exists($key, $current) || null === $current[$key]) {
                $current[$key] = [];
            }

            $this->doSet($current[$key], $segs, $value);

            return;
        }

        if ($current instanceof \ArrayAccess) {
            $key = $this->castArrayKey($seg);

            if ($isLast) {
                $current[$key] = $value;

                return;
            }
            if (!$current->offsetExists($key) || null === $current[$key]) {
                $current[$key] = [];
            }

            $tmp = $current[$key];
            $this->doSet($tmp, $segs, $value);
            $current[$key] = $tmp;

            return;
        }

        /* @var object $current */ else {
            try {
                $next = $this->propertyAccessor->getValue($current, $seg);
            } catch (\Throwable) {
                return;
            }

            if ($isLast) {
                try {
                    $this->propertyAccessor->setValue($current, $seg, $value);
                } catch (\Throwable) {
                    // TODO: Log error
                }

                return;
            }

            $shouldWriteBack = false;

            if (null === $next) {
                $next = [];
                $shouldWriteBack = true;
            }

            /* @var non-empty-list<string> $segs */
            $this->doSet($next, $segs, $value);

            if ($shouldWriteBack || \is_array($next) || $next instanceof \ArrayAccess) {
                try {
                    $this->propertyAccessor->setValue($current, $seg, $next);
                } catch (\Throwable) {
                    // TODO: Log error
                }
            }
        }
    }

    /** @return list<string> */
    private function tokens(string $path): array
    {
        $path = \trim($path);

        if ('' === $path) {
            return [];
        }

        $parts = \explode('.', $path);

        return \array_values(\array_filter($parts, static fn ($p) => '' !== $p));
    }

    private function castArrayKey(string $seg): int|string
    {
        return \ctype_digit($seg) ? (int) $seg : $seg;
    }
}
