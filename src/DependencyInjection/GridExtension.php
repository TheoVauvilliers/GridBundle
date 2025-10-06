<?php

namespace TheoVauvilliers\GridBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Finder\Finder;

class GridExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $locator = new FileLocator(__DIR__ . '/../../config');
        $loader = new YamlFileLoader($container, $locator);
        $servicesPath = __DIR__ . '/../../config/services';
        $finder = new Finder();

        $finder->files()->in($servicesPath)->name('*.yaml');

        foreach ($finder as $file) {
            $relativePath = 'services/' . $file->getFilename();
            $loader->load($relativePath);
        }
    }
}
