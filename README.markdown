What is it ?
============

This is a bridge between WordPress and Symfony2.

This bundle will allow you to :
- find published posts/pages
    - all of them
    - by slug
- find attachments by mime-type, specifically images

That's all !


Inspired (a lot!) by :
- https://github.com/kayue/WordpressBundle
- and its active fork https://github.com/101medialab/WordpressBundle
- https://github.com/PolishSymfonyCommunity/PSSBlogBundle

I re-did the bundle from scratch because I wanted working and clean tests at all times. Plus, it's a learner's project.

You should not use this bundle, as using both WordPress AND Symfony2 is a bad practice,
but until the [CMF](http://cmf.symfony.com) is media-ready this is a good enough alternative in some fast-food cases.


How to use
==========

1. Create your wordpress as usual
2. Add [this bundle](https://packagist.org/packages/goutte/wordpress-bundle) to your composer.json
3. Register this bundle in your AppKernel.php
4. Configure in app/config.yml

    ```yml
    goutte_wordpress:
        # WP tables prefix, default is 'wp_'
        table_prefix: wp_
    ```

5. Configure your parameters.yml to point towards the wordpress database


Usage examples
==============

You'll need the Entity Manager

```php
$em = $this->get('doctrine')->getEntityManager(); // whichever way you're using to get the em
```


Posts
-----

Will only fetch posts, not pages nor attachments. (see below on how to get those)

```php
$postRepository = $em->getRepository('GoutteWordpressBundle:Post');

$posts = $postRepository->findPublished(); // finds all published posts

// finds a maximum of 5 published posts after omitting the first 3
$posts = $postRepository->findPublished(5,3);

// finds one post by its slug, or returns false
$post = $postRepository->findPublishedBySlug('hello-word');
if (!empty($post)) {
  // ...
}
```


Pages
-----

```php
$pageRepository = $em->getRepository('GoutteWordpressBundle:Page');

$pages = $pageRepository->findPublished(); // finds all published pages

// finds a maximum of 5 published pages after omitting the first 3
$pages = $pageRepository->findPublished(5,3);

// finds one page by its slug, or returns false
$page = $pageRepository->findPublishedBySlug('hello-word');
if (!empty($page)) {
  // ...
}
```


Images
------

```php
<?php
$attachmentRepository = $em->getRepository('GoutteWordpressBundle:Attachment')

// Find all images (attachments whose mime-type starts with 'image/')
$allImages = $attachmentRepository->findImages();

// any mime subtype works as parameter, juste make sure to spell it as wordpress does (eg: jpeg vs jpg)
$pngImages = $attachmentRepository->findImages('png');
$jpgImages = $attachmentRepository->findImages('jpeg');

// you can also pass an array, for convenience
$transparentImages = $attachmentRepository->findImages(array('gif','png', 'webp'));
```


How to setup tests
==================

1. Copy phpunit.xml.dist to phpunit.xml
2. Configure KERNEL_DIR
3. Register this bundle in your AppKernel.php
4. Update your composer.json, as we are using Doctrine Mocks. This is not optimized, how can I restrict this to the test env ?

   ```json
   "autoload": {
     "psr-0": {
       "Doctrine\\Tests\\DBAL": "vendor/doctrine/dbal/tests/"
     }
   }
   ```

5. /!\ Make sure you have another database setup for your tests, because the suite will ruin the database !
6. Run !


Requirements
============

* WordPress 3.4.2


Caveats
=======

* WordPress assumes it will be run in the global scope, so some of its code doesn't even bother
  explicitly globalising variables. The required version of WordPress core marginally improves this
  situation (enough to allow us to integrate with it), but beware that other parts of WordPress or
  plugins may still have related issues.
