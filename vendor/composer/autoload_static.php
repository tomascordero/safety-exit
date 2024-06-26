<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf2ecb409de8af704de7d72a1f05c8ffe
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SafetyExit\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SafetyExit\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'SafetyExit\\Safety_Exit_Admin' => __DIR__ . '/../..' . '/lib/Safety_Exit_Admin.php',
        'SafetyExit\\Safety_Exit_Frontend' => __DIR__ . '/../..' . '/lib/Safety_Exit_Frontend.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf2ecb409de8af704de7d72a1f05c8ffe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf2ecb409de8af704de7d72a1f05c8ffe::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf2ecb409de8af704de7d72a1f05c8ffe::$classMap;

        }, null, ClassLoader::class);
    }
}
