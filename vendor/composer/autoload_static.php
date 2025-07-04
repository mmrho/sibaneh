<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit926082df67eab15f4b36522a3f043517
{
    public static $files = array (
        'b921cbe71015ab88f1303c3f2da73e4f' => __DIR__ . '/../..' . '/class/WbsUtility.php',
        'd92100d97b1c6956c69b29ec38c98a6f' => __DIR__ . '/../..' . '/class/calculate-reading-time.php',
        '3e931f6749a57dac0e04ffa8e83cff81' => __DIR__ . '/../..' . '/class/copy-link.php',
        'dd64e540f99ce8d7014553c8d43ce992' => __DIR__ . '/../..' . '/class/split-post-content.php',
        'cac77d3b20e71eafbee73ae7a96dfa35' => __DIR__ . '/../..' . '/inc/functions/proper-parse.php',
        '9d80bc40cdd8c4617f85deff64ca474c' => __DIR__ . '/../..' . '/inc/functions/PageNav.php',
        '88b81fda764f5ef43ed005963c136e3a' => __DIR__ . '/../..' . '/inc/functions/user-custom-fields.php',
        'a4c7bf19607b3027d53b44302d68b3f2' => __DIR__ . '/../..' . '/inc/functions/global-create-tables.php',
        '6d7b86cc73223a83aea75823dfda9c5a' => __DIR__ . '/../..' . '/inc/functions/remove-email-required.php',
        '14ba2767e306c56d684f63e94c03bc33' => __DIR__ . '/../..' . '/inc/functions/hide-admin-bar.php',
        '9f48162bcafc22cce4619c8bdca211d8' => __DIR__ . '/../..' . '/inc/functions/SMS-ir.php',
        '00b72cb68d786bb421d1ee2059ee114e' => __DIR__ . '/../..' . '/inc/functions/global-ajax.php',
        '549f28ab2bed3ed0807f97062eb9a467' => __DIR__ . '/../..' . '/inc/functions/admin-menu.php',
        'edd2c0a6c24f95966b7374e64523f7b5' => __DIR__ . '/../..' . '/inc/functions/start_session.php',
        'eddb9150cab1d47ade3e2ff708538b65' => __DIR__ . '/../..' . '/inc/functions/wp-enqueue.php',
        '1de63ed172445026057d3c5bc9f63de5' => __DIR__ . '/../..' . '/inc/functions/disable-wp-admin.php',
        'df17d88f00d7373d412c1aa16d832c92' => __DIR__ . '/../..' . '/inc/functions/add-roles.php',
        'c208f475b61717233f8225fa0353d0ae' => __DIR__ . '/../..' . '/inc/functions/theme-options.php',
        '6dbfdeef30519b60233492cac6d4f3a6' => __DIR__ . '/../..' . '/inc/functions/menu.php',
        '4a83b37129298a7e10da35add94b49a8' => __DIR__ . '/../..' . '/lib/Login/wbsLogin.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sibaneh\\WpTheme\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sibaneh\\WpTheme\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit926082df67eab15f4b36522a3f043517::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit926082df67eab15f4b36522a3f043517::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit926082df67eab15f4b36522a3f043517::$classMap;

        }, null, ClassLoader::class);
    }
}
