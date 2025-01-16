<?php
namespace SafetyExit\Assets;

class Assets
{
    private array $manifest = [];
    private array $assets = [];

    private string $assetRoot;

    private bool $isLocal = false;

    public function __construct($assetRoot = null)
    {
        $this->isLocal = defined('IS_LOCAL') && IS_LOCAL;

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
        foreach($this->getStyles('admin') as $style) {
            $uuid = uniqid();
            wp_enqueue_style('sftExt-admin-' . $uuid, $this->assetRoot . $style);
        }

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
            wp_enqueue_script_module('sftExt-admin-' . uniqid(), $this->assetRoot . $this->getScripts('admin'), '', '', true);
        } else {
            wp_enqueue_script('sftExt-admin-' . uniqid(), $this->assetRoot . $this->getScripts('admin'), '', '', true);
        }
    }
}
