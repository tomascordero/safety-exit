<?php
namespace SafetyExit\Helpers;

use SafetyExit\Exceptions\InvalidSetting;

class Settings
{
    private static $defaultSettings = [
        'sftExt_position' => 'bottom right',
        'sftExt_fontawesome_icon_classes' => 'fas fa-times',
        'sftExt_type' => 'rectangle',
        'sftExt_current_tab_url' => 'https://google.com',
        'sftExt_new_tab_url' => 'https://google.com',
        'sftExt_rectangle_text' => 'Safety Exit',
        'sftExt_rectangle_icon_onOff' => 'yes',
        'sftExt_rectangle_font_size_units' => 'rem',
        'sftExt_rectangle_font_size' => '1',
        'sftExt_bg_color' => 'rgba(58, 194, 208, 1)',
        'sftExt_font_color' => 'rgba(255, 255, 255, 1)',
        'sftExt_letter_spacing' => 'inherit',
        'sftExt_border_radius' => '100',
        'sftExt_hide_mobile' => '',
        'sftExt_show_all' => 'yes',
        'sftExt_front_page' => 'yes',
        'sftExt_pages' => []
    ];

    public static function getAll()
    {
        return wp_parse_args(get_option('sftExt_settings'), self::getDefaults());
    }

    public static function getDefaults()
    {
        return static::$defaultSettings;
    }

    public static function update($key, $value)
    {
        $defaultSettings = self::getDefaults();
        if (!array_key_exists($key, $defaultSettings)) {
            throw new InvalidSetting("Invalid setting key: $key");
        }

        $settings = self::getAll();

        $updatedSettings = array_merge($settings, [$key => $value]);
        self::saveSettings($updatedSettings);
    }

    public static function get($key)
    {
        $settings = self::getAll();
        return $settings[$key];
    }

    private static function saveSettings($settings)
    {
        update_option('sftExt_settings', $settings);
    }
}
