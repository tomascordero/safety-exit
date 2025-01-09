<?php

use SafetyExit\Helpers\Settings;
use SafetyExit\Exceptions\InvalidSetting;

beforeEach(function () {

    $this->updatedOptions = [];
    Brain\Monkey\Functions\stubs([
        'wp_parse_args' => function ($args, $defaults) {
            return array_merge($defaults, $args);
        },
        'get_option' => function ($key) {
            if ($key === 'sftExt_settings') {
                return [
                    'sftExt_rectangle_icon_onOff' => 'no',
                    'sftExt_font_color' => 'rgba(0, 0, 0, 1)',
                ];
            }
            return [];
        },
        'update_option' => function ($key, $value) {
            $this->updatedOptions[$key] = $value;
            return true;
        },
    ]);
});

afterEach(function () {
    Brain\Monkey\tearDown();
});

it('gets all settings including defaults', function () {
    $settings = Settings::getAll();

    expect($settings['sftExt_position'])->toBe('bottom right');
    expect($settings['sftExt_font_color'])->toBe('rgba(0, 0, 0, 1)'); // From stubbed get_option
    expect($settings['sftExt_rectangle_icon_onOff'])->toBe('no'); // From stubbed get_option
    expect($settings['sftExt_letter_spacing'])->toBe('inherit'); // From default
});

it('gets default settings', function () {
    $defaults = Settings::getDefaults();

    expect($defaults['sftExt_position'])->toBe('bottom right');
    expect($defaults['sftExt_font_color'])->toBe('rgba(255, 255, 255, 1)');
});

it('updates a setting successfully', function () {
    $key = 'sftExt_position';
    $value = 'top left';

    Settings::update($key, $value);

    expect($this->updatedOptions['sftExt_settings'])->toHaveKey($key, $value);
});

it('throws an exception when updating an invalid key', function () {
    $key = 'invalid_key';
    $value = 'value';

    expect(fn () => Settings::update($key, $value))->toThrow(InvalidSetting::class, "Invalid setting key: $key");
});

it('saves settings correctly', function () {
    $newSettings = [
        'sftExt_position' => 'top left',
        'sftExt_font_color' => 'rgba(128, 128, 128, 1)',
    ];

    $reflection = new ReflectionClass(Settings::class);
    $saveSettingsMethod = $reflection->getMethod('saveSettings');
    $saveSettingsMethod->setAccessible(true);

    $saveSettingsMethod->invoke(null, $newSettings);

    expect($this->updatedOptions['sftExt_settings'])->toBe($newSettings);
});

it('gets a specific setting by key', function () {
    $key = 'sftExt_font_color';
    $value = Settings::get($key);

    expect($value)->toBe('rgba(0, 0, 0, 1)');
});
