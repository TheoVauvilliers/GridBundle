<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class TheoVauvilliersGridBundle extends AbstractBundle
{
    protected string $extensionAlias = 'grid';

    public function loadExtension(
        array $config,
        ContainerConfigurator $container,
        ContainerBuilder $builder
    ): void {
        $configDir = \dirname(__DIR__) . '/config';
        $servicesDir = $configDir . '/services';

        if (\is_dir($servicesDir)) {
            $container->import($servicesDir . '/*.yaml');
        }
    }
}
