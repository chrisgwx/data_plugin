<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc446a4a818f0200f7c45867bf3bd4039
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

        spl_autoload_register(array('ComposerAutoloaderInitc446a4a818f0200f7c45867bf3bd4039', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc446a4a818f0200f7c45867bf3bd4039', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc446a4a818f0200f7c45867bf3bd4039::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
