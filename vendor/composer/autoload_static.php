<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit33cc848c8199d4f21829bdbea257f9cf
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit33cc848c8199d4f21829bdbea257f9cf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit33cc848c8199d4f21829bdbea257f9cf::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit33cc848c8199d4f21829bdbea257f9cf::$classMap;

        }, null, ClassLoader::class);
    }
}
