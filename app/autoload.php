<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require '/home/shared/libs/symfony221/library221/vendor/autoload.php';
$loader->add('', __DIR__.'/../src/');

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';
}

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
