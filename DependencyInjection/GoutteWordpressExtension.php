<?php
namespace Goutte\WordpressBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class GoutteWordpressExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $alias         = $this->getAlias();
        $processor     = new Processor();
        $configuration = new Configuration();
        $configs = $processor->processConfiguration($configuration, $configs);

        foreach ($configs as $key => $value) {
            $container->setParameter("{$alias}.{$key}", $value);
        }
    }


    public function getAlias()
    {
        return 'goutte_wordpress';
    }
}
