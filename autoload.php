<?php

include_once __DIR__.'/vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("App\\", __DIR__.'/src', true);
$classLoader->addPsr4("Test\\", __DIR__.'/test', true);
$classLoader->register();
