<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0c8f4beac40ad4cc33f2e2ec9745be70
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
        'SafetyExit\\Admin' => __DIR__ . '/../..' . '/lib/Admin.php',
        'SafetyExit\\Frontend' => __DIR__ . '/../..' . '/lib/Frontend.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0c8f4beac40ad4cc33f2e2ec9745be70::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0c8f4beac40ad4cc33f2e2ec9745be70::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0c8f4beac40ad4cc33f2e2ec9745be70::$classMap;

        }, null, ClassLoader::class);
    }
}
