<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8311dbf1762d07d3dbc42c62b67dda98
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'ZipMerge\\' => 9,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PHPZip\\Zip\\' => 11,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ZipMerge\\' => 
        array (
            0 => __DIR__ . '/..' . '/grandt/phpzipmerge/src/ZipMerge',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PHPZip\\Zip\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpzip/phpzip/src/Zip',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'RelativePath' => __DIR__ . '/..' . '/grandt/relativepath/RelativePath.php',
        'com\\grandt\\BinString' => __DIR__ . '/..' . '/grandt/binstring/BinString.php',
        'com\\grandt\\BinStringStatic' => __DIR__ . '/..' . '/grandt/binstring/BinStringStatic.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8311dbf1762d07d3dbc42c62b67dda98::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8311dbf1762d07d3dbc42c62b67dda98::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8311dbf1762d07d3dbc42c62b67dda98::$classMap;

        }, null, ClassLoader::class);
    }
}