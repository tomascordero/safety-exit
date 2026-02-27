<?php

use SafetyExit\Helpers\Settings;
use Brain\Monkey\Functions;

if (!defined('WPINC')) {
    define('WPINC', 'wp-includes');
}
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/fixtures');
}

// Stub WP functions called at the top level during file inclusion
Functions\stubs([
    'plugin_dir_path' => function ($file) {
        return dirname($file) . '/';
    },
    'register_activation_hook' => null,
    'register_uninstall_hook' => null,
    'is_admin' => true,
    'current_user_can' => false,
]);

require_once dirname(__DIR__, 2) . '/safety-exit.php';

Brain\Monkey\tearDown();

afterEach(function () {
    Brain\Monkey\tearDown();
});

it('defines the plugin version constant', function () {
    expect(defined('SAFETY_EXIT_VERSION'))->toBeTrue();
    expect(SAFETY_EXIT_VERSION)->toBe('1.9.0');
});

it('registers default settings and version on activation', function () {
    $defaults = Settings::getDefaults();

    Functions\expect('add_option')
        ->once()
        ->with('sftExt_settings', $defaults);
    Functions\expect('add_option')
        ->once()
        ->with('sftExt_version', '1.9.0');

    safety_exit_activate();
});

it('removes settings and version on uninstall', function () {
    Functions\expect('delete_option')
        ->once()
        ->with('sftExt_settings');
    Functions\expect('delete_option')
        ->once()
        ->with('sftExt_version');

    safety_exit_uninstall();
});
