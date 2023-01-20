<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc7a32608cbb204893787ce4ef8550d14
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc7a32608cbb204893787ce4ef8550d14::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc7a32608cbb204893787ce4ef8550d14::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc7a32608cbb204893787ce4ef8550d14::$classMap;

        }, null, ClassLoader::class);
    }
}
