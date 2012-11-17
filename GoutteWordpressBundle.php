<?php

namespace Goutte\WordpressBundle;

use Doctrine\DBAL\Types\Type;
use Goutte\WordpressBundle\Types\WordPressIdType;
use Goutte\WordpressBundle\Types\WordPressMetaType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;

class GoutteWordpressBundle extends Bundle
{
    public function boot()
    {
        parent::boot();

        // Adding special WordPress types
        if (!Type::hasType(WordPressIdType::NAME)) {
            Type::addType(WordPressIdType::NAME, 'Goutte\WordpressBundle\Types\WordPressIdType');
        }
        if (!Type::hasType(WordPressMetaType::NAME)) {
            Type::addType(WordPressMetaType::NAME, 'Goutte\WordpressBundle\Types\WordPressMetaType');
        }
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
