import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig(({ mode }) => {
    return {
        root: 'src',
        base: mode === 'production' ? '/dist/' : '/',
        build: {
            outDir: '../build',
            assetsDir: '', // Prevent nesting assets in a folder
            manifest: true, // Generate manifest for enqueuing
            emptyOutDir: true,
            rollupOptions: {
                input: {
                    frontend: 'src/js/frontend.js',
                    admin: 'src/js/admin/master.jsx',
                },
            },
        },
        server: {
            hmr: true, // Hot Module Replacement
            port: 8080,
            watch: {
                usePolling: true, // Useful for Docker environments
            },
            proxy: {
                '/wp-admin': 'http://localhost:8080',
                '/wp-json': 'http://localhost:8080',
                '/wp-content': 'http://localhost:8080',
            }
        },
        resolve: {
            alias: {
                '@': '/src'
            }
        },
        plugins: [
            react()
        ]
    }
})
