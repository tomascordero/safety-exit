<?php
namespace SafetyExit\Util;

class Config {
    private static $config = [];

    public static function get($key, $default = null) {
        $keys = explode('.', $key);

        if (!isset(self::$config[$keys[0]])) {
            self::load($keys[0]);
        }

        $value = self::$config;
        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return $default;
            }
            $value = $value[$key];
        }

        return $value;
    }

    public static function set($key, $value) {
        self::$config[$key] = $value;
    }

    private static function load($key) {
        $filePath = plugin_dir_path(__FILE__) . "/../lib/config/{$key}.php";
        if (file_exists($filePath)) {
            self::$config[$key] = include $filePath;
        }
    }
}
