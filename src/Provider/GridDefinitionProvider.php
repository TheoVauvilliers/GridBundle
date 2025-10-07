<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Provider;

use TheoVauvilliers\GridBundle\Constant\GridConfigConstant;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class GridDefinitionProvider
{
    private Finder $finder;

    public function __construct(
        private readonly string $projectDir,
    ) {
        $this->finder = new Finder();
    }

    /**
     * @return array<string, mixed>
     *
     * @throws \Exception
     */
    public function getDefinition(string $name): array
    {
        $definitions = $this->getDefinitions();
        $definition = $definitions[$name] ?? [];

        if (empty($definition)) {
            throw new \Exception(\sprintf('Definition "%s" not found', $name));
        }

        $definition['name'] = $name;

        return $definition;
    }

    /**
     * @return array<string, array<string, mixed>>
     *
     * @throws \Exception
     */
    private function getDefinitions(): array
    {
        $definitions = [];

        /** @var SplFileInfo $file */
        foreach ($this->getFiles() as $file) {
            $definitions = array_merge_recursive($definitions, Yaml::parseFile($file->getPathname()));
        }

        return $definitions;
    }

    /**
     * @return iterable<SplFileInfo>
     *
     * @throws \Exception
     */
    private function getFiles(): iterable
    {
        $this->finder->files()
            ->in($this->projectDir.GridConfigConstant::DIR)
            ->name(\sprintf('%s%s.%s', '*', GridConfigConstant::SUFFIX, GridConfigConstant::EXTENSION))
        ;

        if ($this->finder->hasResults()) {
            return $this->finder->getIterator();
        }

        return [];
    }
}
