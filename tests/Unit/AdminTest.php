<?php

use SafetyExit\Admin;
use Brain\Monkey\Functions;

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
        'plugins_url' => function() {
            return '';
        },
        'sanitize_text_field' => fn($input) => is_scalar($input) ? trim(strip_tags((string) $input)) : '',
        'sanitize_hex_color' => fn($input) => preg_match('/^#[0-9a-fA-F]{6}$/', $input) ? $input : '',
        'absint' => fn($input) => abs(intval($input)),
        'esc_url_raw' => fn($input) => filter_var($input, FILTER_VALIDATE_URL) ?: '',
    ]);
});

afterEach(function () {
    Brain\Monkey\tearDown();
});


it('returns the correct data after sanitizing the settings', function () {
    $admin = new Admin(__FILE__);

    $input = [
        'sftExt_position' => 'bottom left',
        'sftExt_fontawesome_icon_classes' => 'fa fa-bomb',
        'sftExt_bg_color' => '#ff0000',
        'sftExt_font_color' => '#00ff00',
        'sftExt_type' => 'rectangle',
        'sftExt_border_radius' => 10,
        'sftExt_rectangle_font_size' => 16,
        'sftExt_rectangle_font_size_units' => 'rem',
        'sftExt_current_tab_url' => 'https://example.com',
        'sftExt_new_tab_url' => 'javascript:alert(1)',
        'sftExt_rectangle_text' => 'Click',
        'sftExt_letter_spacing' => '1px',
        'sftExt_rectangle_icon_onOff' => 'yes',
        'sftExt_hide_mobile' => 'yes',
        'sftExt_front_page' => 'no',
        'sftExt_show_all' => 'yes',
        'sftExt_pages' => [1, 2, 'abc']
    ];

    $output = $admin->sanitize_settings($input);

    expect($output)->toBeArray();
    expect($output['sftExt_position'])->toBe('bottom left');
    expect($output['sftExt_fontawesome_icon_classes'])->toBe('fa fa-bomb');
    expect($output['sftExt_bg_color'])->toBe('#ff0000');
    expect($output['sftExt_font_color'])->toBe('#00ff00');
    expect($output['sftExt_type'])->toBe('rectangle');
    expect($output['sftExt_border_radius'])->toBe(10);
    expect($output['sftExt_rectangle_font_size'])->toBe(16);
    expect($output['sftExt_rectangle_font_size_units'])->toBe('rem');
    expect($output['sftExt_current_tab_url'])->toBe('https://example.com');
    expect($output['sftExt_new_tab_url'])->toBe('');
    expect($output['sftExt_rectangle_text'])->toBe('Click');
    expect($output['sftExt_letter_spacing'])->toBe('1px');
    expect($output['sftExt_rectangle_icon_onOff'])->toBe('yes');
    expect($output['sftExt_hide_mobile'])->toBe('yes');
    expect($output['sftExt_front_page'])->toBe('no');
    expect($output['sftExt_show_all'])->toBe('yes');
    expect($output['sftExt_pages'])->toBe([1, 2, 0]); // 'abc' becomes 0
});
