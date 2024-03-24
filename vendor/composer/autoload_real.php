<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit2ab6ab3baa160e7c6bc28b3056ad32bd
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit2ab6ab3baa160e7c6bc28b3056ad32bd', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit2ab6ab3baa160e7c6bc28b3056ad32bd', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit2ab6ab3baa160e7c6bc28b3056ad32bd::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}