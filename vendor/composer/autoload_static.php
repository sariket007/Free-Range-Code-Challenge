<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita31072dd3483c6f84e8c70e2e9d404d3
{
    public static $files = array (
        'a0831783392cce4a8c7810c65d72c110' => __DIR__ . '/../..' . '/inc/setup.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SS\\BOOKSHOWCASE\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SS\\BOOKSHOWCASE\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'SS\\BOOKSHOWCASE\\Block_Resources' => __DIR__ . '/../..' . '/inc/class-block_recourses.php',
        'SS\\BOOKSHOWCASE\\Book_Store_Post_Type' => __DIR__ . '/../..' . '/inc/class-book_store_post_type.php',
        'SS\\BOOKSHOWCASE\\Validate_Activation' => __DIR__ . '/../..' . '/inc/class-validate_activation.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita31072dd3483c6f84e8c70e2e9d404d3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita31072dd3483c6f84e8c70e2e9d404d3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita31072dd3483c6f84e8c70e2e9d404d3::$classMap;

        }, null, ClassLoader::class);
    }
}
