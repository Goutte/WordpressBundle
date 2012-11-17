<?php

/**
 * Prefixing WordPress tables
 *
 * Provides a Table Prefix option for the bundle's entities.
 */

namespace Goutte\WordpressBundle\Subscriber;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;

class TablePrefixSubscriber implements EventSubscriber
{
    protected $prefix = '';

    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        // Do not apply prefix if not a WordpressBundle Entity
        if ($args->getClassMetadata()->namespace !== "Goutte\\WordpressBundle\\Entity") {
            return;
        }

        $classMetadata = $args->getClassMetadata();
        $prefix = $this->getTablePrefix($args);

        $classMetadata->setPrimaryTable(array('name'=>$prefix.$classMetadata->getTableName()));
    }

    private function getTablePrefix(LoadClassMetadataEventArgs $args)
    {
        $prefix = $this->prefix;

        // Append blog id to prefix, if needed.
//        if( method_exists($args->getEntityManager()->getMetadataFactory(), 'getBlogId') &&
//            $args->getClassMetadata()->name !== "Goutte\\WordpressBundle\\Entity\\User" &&
//            $args->getClassMetadata()->name !== "Goutte\\WordpressBundle\\Entity\\UserMeta") {
//            $prefix .= $args->getEntityManager()->getMetadataFactory()->getBlogId().'_';
//        }

        return $prefix;
    }
}
