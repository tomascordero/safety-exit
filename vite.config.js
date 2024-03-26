import vue from '@vitejs/plugin-vue';
import svgLoader from 'vite-svg-loader';
import path from 'path';
import {
    defineConfig
} from 'vite';

export default defineConfig({
    plugins: [
        vue(),
        svgLoader(),
    ],
    build: {
        manifest: true,
        outDir: 'dist',
        rollupOptions: {
            input: {
                frontend: './src/js/frontend.js',
                admin: './src/js/admin.js',
            },
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './src/js'),
            '@styles': path.resolve(__dirname, './src/css')
        }
    },
    // CSS options
    css: {},
})
