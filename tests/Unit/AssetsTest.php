<?php

use SafetyExit\Assets\Assets;
uses()->group('assets');

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



it('loads the manifest', function () {
    $assets = new Assets();
    $manifest = $assets->getManifest();

    expect($manifest)->toBeArray();
});
