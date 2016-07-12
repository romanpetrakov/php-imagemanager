<?php


namespace ImageManagerDemo;

use OLOG\ImageManager\ImageManagerConfig;
use OLOG\ImageManager\ImageManagerConstants;
use OLOG\Storage\LocalStorage;
use OLOG\Storage\StorageConfigKeys;

class ImageManagerDemoCommonConfig
{
    const STORAGE1_NAME = 'STORAGE1_NAME';
    const IMAGE_PRESET_320_240 = 'IMAGE_PRESET_320_240';
    const IMAGE_PRESET_640_360 = 'IMAGE_PRESET_640_360';
    const IMAGE_PRESET_300_AUTO = 'IMAGE_PRESET_300_AUTO';
    const IMAGE_PRESET_UPLOAD = 'IMAGE_PRESET_UPLOAD';

    public static function get()
    {
        date_default_timezone_set('Europe/Moscow');

        $conf = [];

        $conf[\OLOG\Model\ModelConstants::MODULE_CONFIG_ROOT_KEY] = array(
            'db' => array(
                \OLOG\Auth\Constants::DB_NAME_PHPAUTH => array(
                    'host' => '127.0.0.1',
                    'db_name' => 'db_phpimagemanagerdemo',
                    'user' => 'root',
                    'pass' => '1',
                    'sql_file' => 'vendor/o-log/php-auth/db_phpauth.sql'
                ),
                \OLOG\ImageManager\ImageManagerConstants::DB_NAME_PHPIMAGEMANAGER => array(
                    'host' => '127.0.0.1',
                    'db_name' => 'db_phpimagemanagerdemo',
                    'user' => 'root',
                    'pass' => '1',
                )
            ),
            'memcache_servers' => array(
                'localhost:11211'
            )
        );

        $conf[StorageConfigKeys::ROOT] = array(
            StorageConfigKeys::STORAGES_ARR => array(
                self::STORAGE1_NAME => new LocalStorage('/mnt/s1/'),
            ),
        );

        $conf[ImageManagerConstants::MODULE_NAME] = new ImageManagerConfig(
            [
                's1' => self::STORAGE1_NAME
            ],
            self::IMAGE_PRESET_UPLOAD,
            '/tmp/',
            [
                self::IMAGE_PRESET_320_240 => Presets\Preset320x240::class,
                self::IMAGE_PRESET_UPLOAD => \OLOG\ImageManager\Presets\PresetUpload::class,
                self::IMAGE_PRESET_640_360 => Presets\Preset640x360::class,
                self::IMAGE_PRESET_300_AUTO => Presets\Preset300xAuto::class,

            ],
            [
                '320_240' => self::IMAGE_PRESET_320_240,
                'upload' => self::IMAGE_PRESET_UPLOAD,
                '640_360' => self::IMAGE_PRESET_640_360,
                '300_auto' => self::IMAGE_PRESET_300_AUTO
            ]
        );

        $conf['php-bt'] = [
            'layout_code' => \OLOG\BT\LayoutGentellela::LAYOUT_CODE_GENTELLELA,
            'menu_classes_arr' => [
                \ImageManagerDemo\ImageManagerDemoMenu::class
            ]
        ];
        return $conf;
    }
}