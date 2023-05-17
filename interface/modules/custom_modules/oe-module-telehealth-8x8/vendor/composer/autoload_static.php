<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit43e5f85e3e4189998ba3800f325dee03
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lcobucci\\JWT\\' => 13,
            'Lcobucci\\Clock\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lcobucci\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/lcobucci/jwt/src',
        ),
        'Lcobucci\\Clock\\' => 
        array (
            0 => __DIR__ . '/..' . '/lcobucci/clock/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit43e5f85e3e4189998ba3800f325dee03::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit43e5f85e3e4189998ba3800f325dee03::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit43e5f85e3e4189998ba3800f325dee03::$classMap;

        }, null, ClassLoader::class);
    }
}