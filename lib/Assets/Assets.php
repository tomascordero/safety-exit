<?php
namespace SafetyExit\Assets;

use SafetyExit\Helpers\Settings;

class Assets
{
    private array $manifest = [];
    private array $assets = [];
    private array $options = [];

    private string $assetRoot;
    private string $publicPluginRoot;

    private bool $isLocal = false;

    public function __construct($assetRoot = null)
    {
        $this->isLocal = defined('IS_LOCAL') && IS_LOCAL;
        $this->options = Settings::getAll();
        $this->publicPluginRoot = $assetRoot;

        if ($this->isLocal) {
            $this->assetRoot = 'http://localhost:5173/';
        } else {
            $this->assetRoot = $assetRoot . 'dist/';

            if (file_exists(sftExtConfig('assets.manifest'))) {
                $this->manifest = json_decode(file_get_contents(sftExtConfig('assets.manifest')), true);

                foreach($this->manifest as $key => $value) {
                    $this->assets[$value['name']] = [
                        'css' => $value['css'],
                        'js' => $value['file'],
                    ];
                }
            }
        }

    }

    public function getManifest(): array
    {
        return $this->manifest;
    }

    public function getAllAssets(): array
    {
        return $this->assets;
    }

    public function getStyles($key): array
    {
        if ($this->isLocal) {
            return ["css/{$key}.css"];
        }
        return $this->assets[$key]['css'];
    }

    public function getScripts($key): string
    {
        if ($this->isLocal) {
            return "js/{$key}.jsx";
        }
        return $this->assets[$key]['js'];
    }

    public function admin(): void
    {
        // Enqueue styles
        wp_enqueue_style( 'wp-components' );
        foreach($this->getStyles('admin') as $style) {
            $uuid = uniqid();
            wp_enqueue_style("sftExt-admin-$uuid", $this->assetRoot . $style);
        }
        $buttonStyles = "
            :root {
                --sftExt_bgColor: " . esc_attr( Settings::get('sftExt_bg_color') ) . ";
                --sftExt_textColor: " . esc_attr( Settings::get('sftExt_font_color') ) . ";
                --sftExt_active: inline-block;
                --sftExt_activeMobile: inline-block;
                --sftExt_mobileBreakPoint: 600px;
                --sftExt_rectangle_fontSize: " . esc_attr( Settings::get('sftExt_rectangle_font_size') ) . esc_attr( Settings::get('sftExt_rectangle_font_size_units') ) . ";
                --sftExt_rectangle_letterSpacing: " . esc_attr( Settings::get('sftExt_letter_spacing') ) . ";
                --sftExt_rectangle_borderRadius: " . esc_attr( Settings::get('sftExt_border_radius') ) . "px;
            }
		";
        wp_add_inline_style(
            'wp-components',
            $buttonStyles
        );

        $frontEndObject = [
            'settings' => $this->options,
            'icons' => $this->getBaseIcons(),
        ];
        // Enqueue scripts
        if ($this->isLocal) {
            add_action('admin_head', function() { ?>
                <script type="module">
                    import RefreshRuntime from "http://localhost:5173/@react-refresh"
                    RefreshRuntime.injectIntoGlobalHook(window)
                    window.$RefreshReg$ = () => {}
                    window.$RefreshSig$ = () => (type) => type
                    window.__vite_plugin_react_preamble_installed__ = true
                </script>
            <?php });
            wp_enqueue_script_module("sftExt-admin-script", $this->assetRoot . $this->getScripts('admin'), ['sftExt-admin-settings'], '', true);

            wp_register_script(
                'sftExt-admin-settings',
                '',
                [],
                '',
                true
            );
            wp_add_inline_script(
                'sftExt-admin-settings',
                sprintf(
                    'window.SafetyExitSettings = %s;',
                    wp_json_encode($frontEndObject)
                )
            );
            wp_enqueue_script('sftExt-admin-settings');
        } else {
            wp_enqueue_script("sftExt-admin-script", $this->assetRoot . $this->getScripts('admin'), '', '', true);
            wp_localize_script("sftExt-admin-script", 'SafetyExitSettings', $frontEndObject);
        }

    }

    public function getBaseIcons(): array
    {
        $iconsFolder = plugin_dir_path( __FILE__ ) . '../../assets/icons/';
        $icons = array();

        // Need to serve these up like: ['fileName' => 'path/to/file']
        // In the database I need to crate two new fields.
        if (is_dir($iconsFolder)) {
            $files = scandir($iconsFolder);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'svg') {
                    $icons[] = $this->publicPluginRoot . 'assets/icons/' . $file;
                }
            }
        }

        return $icons;
    }
}
