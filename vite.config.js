// vite.config.js
import {
    defineConfig
} from 'vite';

export default defineConfig({
    root: 'src',
    server: {
        watch: {
            include: ['src/**/**'],
            exclude: ['node_modules']
        },
    },
    build: {
        outDir: 'assets',
        emptyOutDir: false,
        rollupOptions: {
            input: {
                frontend: 'src/js/frontend.js',
                // TODO: Refactor the admin scripts to not need external libraries.
                admin: 'src/js/admin.js',
                'fontawesome-iconpicker.min': 'src/js/fontawesome-iconpicker.min.js',
                'vanilla-picker.min': 'src/js/vanilla-picker.min.js',
            },
            output: {
                dir: 'assets',
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: 'css/[name].[ext]',
            },
        },
    },
    resolve: {
        alias: {
            '@': '/src'
        }
    },
    // CSS options
    css: {},
})
