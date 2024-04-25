<?php

use SafetyExit\Safety_Exit_Frontend;
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
        'do_action' => true,
    ]);
});

afterEach(function () {
    // Ensure that the expectations are checked
    Brain\Monkey\tearDown();
});

it('calls wp_enqueue_scripts and wp_head actions on init', function () {

    $safetyExitFrontend = new Safety_Exit_Frontend();


    $this->assertInstanceOf(Safety_Exit_Frontend::class, $safetyExitFrontend);

    // Assert that add_action was called with the expected parameters
    Functions\expect('add_action')
        ->once()
        ->with('wp_enqueue_scripts', [$safetyExitFrontend, 'sftExt_enqueue']);
    Functions\expect('add_action')
        ->once()
        ->with('wp_body_open', [$safetyExitFrontend, 'echo_safety_exit_html'], 100);
    Functions\expect('add_action')
        ->once()
        ->with('wp_head', [$safetyExitFrontend, 'echo_safety_exit_custom_styling']);

    // Call the init method
    $safetyExitFrontend->init();
});

it('enqueues the necessary styles and scripts', function () {
    $safetyExitFrontend = new Safety_Exit_Frontend();

    // Assert that wp_enqueue_style and wp_enqueue_script were called with the expected parameters
    Functions\expect('wp_enqueue_style')
        ->once()
        ->with('frontendCSS', '/safety-exit/assets/css/frontend.css');
    Functions\expect('wp_enqueue_script')
        ->once()
        ->with('frontendJs', '/safety-exit/assets/js/frontend.js', ['jquery']);
    Functions\expect('wp_enqueue_style')
        ->once()
        ->with('font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css');

    // Call the sftExt_enqueue method
    $safetyExitFrontend->sftExt_enqueue();
    // Brain\Monkey\tearDown();
});

it('does not enqueue font-awesome-free style if sftExt_rectangle_icon_onOff is no', function () {
    $safetyExitFrontend = new Safety_Exit_Frontend();

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

    $safetyExitFrontend->sftExt_enqueue();
});

it('generates the correct custom JS', function () {
    Functions\when('do_action')->justReturn(null);
    Functions\when('get_the_ID')->justReturn(1);
    Functions\when('is_front_page')->justReturn(false);
    Functions\when('esc_attr')->alias(function($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    });
    $safetyExitFrontend = new Safety_Exit_Frontend();
    $safetyExitFrontend->run_setup();
    $js = $safetyExitFrontend->generate_js();
    $this->assertIsString($js);

    $this->assertEquals($js, "<script>window.sftExtBtn={};window.sftExtBtn.classes='bottom right rectangle';window.sftExtBtn.icon='<i class=\"fas fa-times\"></i>';window.sftExtBtn.newTabUrl='https://google.com';window.sftExtBtn.currentTabUrl='https://google.com';window.sftExtBtn.btnType='rectangle';window.sftExtBtn.text='Safety Exit';window.sftExtBtn.shouldShow=true;</script>");

});

it('generates the correct custom CSS', function () {
    Functions\when('do_action')->justReturn(null);
    Functions\when('get_the_ID')->justReturn(1);
    Functions\when('is_front_page')->justReturn(false);
    Functions\when('esc_attr')->alias(function($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    });
    $safetyExitFrontend = new Safety_Exit_Frontend();
    $safetyExitFrontend->run_setup();
    $css = $safetyExitFrontend->generate_css();
    $this->assertIsString($css);

    $this->assertEquals($css, "<style>:root{--sftExt_bgColor:rgba(58, 194, 208, 1);--sftExt_textColor:rgba(255, 255, 255, 1);--sftExt_active:inline-block;--sftExt_activeMobile:inline-block;--sftExt_mobileBreakPoint:600px;--sftExt_rectangle_fontSize:1rem;--sftExt_rectangle_letterSpacing:inherit;--sftExt_rectangle_borderRadius:100px;}</style>");

});

it('generates the correct custom HTML', function () {
    Functions\when('do_action')->justReturn(null);
    Functions\when('get_the_ID')->justReturn(1);
    Functions\when('is_front_page')->justReturn(false);
    Functions\when('esc_attr')->alias(function($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    });
    $safetyExitFrontend = new Safety_Exit_Frontend();
    $safetyExitFrontend->run_setup();
    $html = $safetyExitFrontend->generate_html();
    $this->assertIsString($html);

    $this->assertEquals($html, "<button id=\"sftExt-frontend-button\" class=\"bottom right rectangle\" data-new-tab=\"https://google.com\" data-url=\"https://google.com\"><div class=\"sftExt-inner\"><i class=\"fas fa-times\"></i><span>Safety Exit</span></div></button>");

});
