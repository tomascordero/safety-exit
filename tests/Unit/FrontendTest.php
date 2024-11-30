<?php

use SafetyExit\Frontend;
use Brain\Monkey\Functions;

beforeEach(function () {
    Functions\stubs([
        'wp_parse_args' => function($args, $defaults) {
            return array_merge($defaults, $args);
        },
        'get_option' => function() {
            return [
                'sftExt_rectangle_icon_onOff' => 'yes',
                'sftExt_position' => 'bottom right',
                'sftExt_fontawesome_icon_classes' => 'fas fa-times',
                'sftExt_type' => 'rectangle',
                'sftExt_current_tab_url' => 'https://google.com',
                'sftExt_new_tab_url' => 'https://google.com',
                'sftExt_rectangle_text' => 'Safety Exit',
                'sftExt_rectangle_font_size_units' => 'rem',
                'sftExt_rectangle_font_size' => '1',
                'sftExt_bg_color' => 'rgba(58, 194, 208, 1)',
                'sftExt_font_color' => 'rgba(255, 255, 255, 1)',
                'sftExt_letter_spacing' => 'inherit',
                'sftExt_border_radius' => '100',
                'sftExt_hide_mobile' => '',
                'sftExt_show_all' => 'yes',
                'sftExt_front_page' => 'yes',
                'sftExt_pages' => array(),
            ];
        },
        'plugins_url' => function() {
            return '';
        },
        'is_front_page' => function() {
            return true;
        },
        'do_action' => true
    ]);
});

afterEach(function () {
    // Ensure that the expectations are checked
    Brain\Monkey\tearDown();
});

it('calls wp_enqueue_scripts and wp_head actions on init', function () {


    $safetyExitFrontend = new Frontend();


    $this->assertInstanceOf(Frontend::class, $safetyExitFrontend);

    // Assert that add_action was called with the expected parameters
    Functions\expect('add_action')
        ->once()
        ->with('wp_enqueue_scripts', [$safetyExitFrontend, 'enqueueScripts']);
    Functions\expect('add_action')
        ->once()
        ->with('wp_head', [$safetyExitFrontend, 'runSetup']);
    Functions\expect('add_action')
        ->once()
        ->with('wp_head', [$safetyExitFrontend, 'outputStyles']);
    Functions\expect('add_action')
        ->once()
        ->with('wp_body_open', [$safetyExitFrontend, 'outputHtml'], 100);

    // Call the init method
    $safetyExitFrontend->init();
});

it('does not enqueue font-awesome-free style if sftExt_rectangle_icon_onOff is no', function () {
    $safetyExitFrontend = new Frontend();

    Functions\expect('wp_enqueue_style')
        ->once()
        ->with('frontendCSS', '/safety-exit/assets/css/frontend.css');
    Functions\expect('wp_enqueue_script')
        ->once()
        ->with('frontendJs', '/safety-exit/assets/js/frontend.js', ['jquery']);
    Functions\expect('wp_enqueue_style')
        ->never()
        ->with('font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css');

    Functions\when('get_option')->justReturn(['sftExt_rectangle_icon_onOff' => 'no']);
    Functions\expect('wp_enqueue_style')
        ->never()
        ->with('font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css');

    $safetyExitFrontend->enqueueScripts();
});

it('generates the correct css and js', function () {
    Functions\when('do_action')->justReturn(null);
    Functions\when('get_the_ID')->justReturn(1);
    Functions\when('is_front_page')->justReturn(false);
    Functions\when('esc_attr')->alias(function($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    });
    $safetyExitFrontend = new Frontend();
    $safetyExitFrontend->runSetup();
    ob_start();
    $safetyExitFrontend->outputStyles();
    $output = ob_get_clean();
    $this->assertIsString($output);

    $this->assertEquals($output, "<script>window.sftExtBtn={\"classes\":\"bottom right rectangle\",\"icon\":\"<i class=\\\"fas fa-times\\\"><\/i>\",\"newTabUrl\":\"https:\/\/google.com\",\"currentTabUrl\":\"https:\/\/google.com\",\"btnType\":\"rectangle\",\"text\":\"Safety Exit\",\"shouldShow\":true};</script><style>:root{--sftExt_bgColor:rgba(58, 194, 208, 1);--sftExt_textColor:rgba(255, 255, 255, 1);--sftExt_active:inline-block;--sftExt_activeMobile:inline-block;--sftExt_mobileBreakPoint:600px;--sftExt_rectangle_fontSize:1rem;--sftExt_rectangle_letterSpacing:inherit;--sftExt_rectangle_borderRadius:100px;}</style>");

});

it('generates the correct custom HTML', function () {
    Functions\when('do_action')->justReturn(null);
    Functions\when('get_the_ID')->justReturn(1);
    Functions\when('is_front_page')->justReturn(false);
    Functions\when('esc_attr')->alias(function($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    });
    $safetyExitFrontend = new Frontend();
    $safetyExitFrontend->runSetup();
    ob_start();
    $safetyExitFrontend->outputHtml();
    $output = ob_get_clean();
    $this->assertIsString($output);

    $this->assertEquals($output, "<button id=\"sftExt-frontend-button\" class=\"bottom right rectangle\" data-new-tab=\"https://google.com\" data-url=\"https://google.com\"><div class=\"sftExt-inner\"><i class=\"fas fa-times\"></i><span>Safety Exit</span></div></button>");

});
