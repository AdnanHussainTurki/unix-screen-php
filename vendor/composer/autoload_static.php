<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbec361679b47b6f572833f43c7c45256
{
    public static $files = array (
        '6124b4c8570aa390c21fafd04a26c69f' => __DIR__ . '/..' . '/myclabs/deep-copy/src/DeepCopy/deep_copy.php',
        '4384ae2b1c411dab75a78e15f1b182ad' => __DIR__ . '/..' . '/nahid/qarray/helpers/qarray.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
        'fd867582e8863a0158e17d8954f1762f' => __DIR__ . '/..' . '/nahid/jsonq/helpers/jsonq.php',
    );

    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'myPHPnotes\\' => 11,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Component\\Process\\' => 26,
        ),
        'N' => 
        array (
            'Nahid\\QArray\\' => 13,
            'Nahid\\JsonQ\\' => 12,
        ),
        'D' => 
        array (
            'DeepCopy\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'myPHPnotes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'Nahid\\QArray\\' => 
        array (
            0 => __DIR__ . '/..' . '/nahid/qarray/src',
        ),
        'Nahid\\JsonQ\\' => 
        array (
            0 => __DIR__ . '/..' . '/nahid/jsonq/src',
        ),
        'DeepCopy\\' => 
        array (
            0 => __DIR__ . '/..' . '/myclabs/deep-copy/src/DeepCopy',
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbec361679b47b6f572833f43c7c45256::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbec361679b47b6f572833f43c7c45256::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbec361679b47b6f572833f43c7c45256::$classMap;

        }, null, ClassLoader::class);
    }
}
