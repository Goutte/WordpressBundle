<?php
namespace Goutte\WordpressBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for the WordPressBundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Build and return a config tree.
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder->root('goutte_wordpress')
            ->children()
//                ->scalarNode('wordpress_path')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('table_prefix')->defaultValue('wp_')->end()
            ->end()
        ;

        return $builder;
    }
}
