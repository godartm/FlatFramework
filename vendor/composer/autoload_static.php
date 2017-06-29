<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit10d375dfc244cc7cf6ed7755b5e6f307
{
    public static $files = array(
        'e1edc6b39e340029dfa1d72c228b8497' => __DIR__ . '/..' . '/xiaoler/blade/src/helpers.php',
        '17fd9fef37c97cfdc0c7794299a8423d' => __DIR__ . '/..' . '/vrana/notorm/NotORM.php',
    );

    public static $prefixLengthsPsr4 = array(
        'X' =>
            array(
                'Xiaoler\\Blade\\' => 14,
            ),
        'W' =>
            array(
                'Whoops\\' => 7,
            ),
        'P' =>
            array(
                'Psr\\Log\\'            => 8,
                'PrivateHeberg\\Flat\\' => 19,
            ),
    );

    public static $prefixDirsPsr4 = array(
        'Xiaoler\\Blade\\'      =>
            array(
                0 => __DIR__ . '/..' . '/xiaoler/blade/src',
            ),
        'Whoops\\'              =>
            array(
                0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
            ),
        'Psr\\Log\\'            =>
            array(
                0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
            ),
        'PrivateHeberg\\Flat\\' =>
            array(
                0 => __DIR__ . '/..' . '/privateheberg/flat',
            ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit10d375dfc244cc7cf6ed7755b5e6f307::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit10d375dfc244cc7cf6ed7755b5e6f307::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
