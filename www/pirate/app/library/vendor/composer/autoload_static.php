<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit61a208881d9074bb11ca3a8d41428a38
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '667aeda72477189d0494fecd327c3641' => __DIR__ . '/..' . '/symfony/var-dumper/Resources/functions/dump.php',
        'e7223560d890eab89cda23685e711e2c' => __DIR__ . '/..' . '/psy/psysh/src/Psy/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'X' => 
        array (
            'XdgBaseDir\\' => 11,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\VarDumper\\' => 28,
            'Symfony\\Component\\Debug\\' => 24,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'P' => 
        array (
            'Psy\\' => 4,
            'Psr\\Log\\' => 8,
            'PhpParser\\' => 10,
            'Phalcon\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'XdgBaseDir\\' => 
        array (
            0 => __DIR__ . '/..' . '/dnoegel/php-xdg-base-dir/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\VarDumper\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/var-dumper',
        ),
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Psy\\' => 
        array (
            0 => __DIR__ . '/..' . '/psy/psysh/src/Psy',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PhpParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/php-parser/lib/PhpParser',
        ),
        'Phalcon\\' => 
        array (
            0 => __DIR__ . '/..' . '/phalcon/devtools/scripts/Phalcon',
        ),
    );

    public static $prefixesPsr0 = array (
        'J' => 
        array (
            'JakubOnderka\\PhpConsoleHighlighter' => 
            array (
                0 => __DIR__ . '/..' . '/jakub-onderka/php-console-highlighter/src',
            ),
            'JakubOnderka\\PhpConsoleColor' => 
            array (
                0 => __DIR__ . '/..' . '/jakub-onderka/php-console-color/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit61a208881d9074bb11ca3a8d41428a38::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit61a208881d9074bb11ca3a8d41428a38::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit61a208881d9074bb11ca3a8d41428a38::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
