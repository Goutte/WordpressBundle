<?php

// For each path specified in the phpunit.xml as a server value, make sure it is absolute
foreach (array('KERNEL_DIR') as $component) {
    if (!isset($_SERVER[$component])) {
        throw new \RuntimeException("phpunit.xml : You must set the {$component} path as a server variable.");
    }

    if (0 === strpos($_SERVER[$component], '..')) { # The path is relative
        $realPath = realpath(__DIR__ . "/../{$_SERVER[$component]}");
        if (false === $realPath) {
            throw new \RuntimeException("phpunit.xml: The {$component} path points to nothing : '{$realPath}'.");
        }
        $_SERVER[$component] = $realPath;
    }
}

// Load sf2 bootstrap
$loader = require $_SERVER['KERNEL_DIR'] . '/bootstrap.php.cache';