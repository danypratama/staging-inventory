<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite411e9f6b0a5c463dea86684f5785884
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite411e9f6b0a5c463dea86684f5785884::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite411e9f6b0a5c463dea86684f5785884::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite411e9f6b0a5c463dea86684f5785884::$classMap;

        }, null, ClassLoader::class);
    }
}
