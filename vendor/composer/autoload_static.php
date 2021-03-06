<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcce31b6ac666bee5f159ca5f430aab84
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcce31b6ac666bee5f159ca5f430aab84::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcce31b6ac666bee5f159ca5f430aab84::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcce31b6ac666bee5f159ca5f430aab84::$classMap;

        }, null, ClassLoader::class);
    }
}
