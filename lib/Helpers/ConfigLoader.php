<?php
namespace SafetyExit\Helpers;

class ConfigLoader
{
    protected static $config = [];

    public static function load($file)
    {
        if (!isset(self::$config[$file])) {
            $filePath = plugin_dir_path(__FILE__) . '../config/' . $file . '.php';

            if (file_exists($filePath)) {
                self::$config[$file] = include $filePath;
            } else {
                return [];
            }
        }

        return self::$config[$file];
    }

    public static function get($key, $default = null)
    {
        $segments = explode('.', $key);
        $file = array_shift($segments);
        $config = self::load($file);

        foreach ($segments as $segment) {
            if (isset($config[$segment])) {
                $config = $config[$segment];
            } else {
                return $default;
            }
        }

        return $config;
    }
}
