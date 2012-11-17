What is it ?
============

This is a bridge between WordPress and Symfony2.
It provides Repositories and Entities for reading the WP database.

Inspired (a lot!) by :
- https://github.com/kayue/WordpressBundle
- and its active fork https://github.com/101medialab/WordpressBundle
- https://github.com/PolishSymfonyCommunity/PSSBlogBundle

I re-did the bundle from scratch because I wanted working and clean tests at all times. Plus, it's a learner's project.

You should not use this bundle, as using both WordPress AND Symfony2 is a bad practice,
but until the [CMF](http://cmf.symfony.com) is media-ready this is a good enough alternative.


How to use
==========

1. Register this bundle in your AppKernel.php
2. Configure in app/config.yml

    ```yml
    goutte_wordpress:
        # WP tables prefix, default is 'wp_'
        table_prefix: wp_
    ```


Usage examples
==============

In a Controller

    ```php
    <?php
    class WordpressController extends Controller
    {
        public function listAction() {
          $em = $this->get('doctrine')->getEntityManager();
          $repository = $em->getRepository('GoutteWordpressBundle:Post');

          $posts  = $repository->findPublishedPosts();
          $images = $repository->findJpegImages();

          // ...
        }
    }
    ```



How to setup tests
==================

1. Copy phpunit.xml.dist to phpunit.xml
2. Configure KERNEL_DIR
3. Register this bundle in your AppKernel.php
4. Update your composer.json, as we are using Doctrine Mocks.
   This is not optimized, how can I restrict this to the test env ?

   ```json
   "autoload": {
     "psr-0": {
       "Doctrine\\Tests\\DBAL": "vendor/doctrine/dbal/tests/"
     }
   }
   ```

5. Run !


Requirements
============

* WordPress 3.4.2


Caveats
=======

* WordPress assumes it will be run in the global scope, so some of its code doesn't even bother
  explicitly globalising variables. The required version of WordPress core marginally improves this
  situation (enough to allow us to integrate with it), but beware that other parts of WordPress or
  plugins may still have related issues.
