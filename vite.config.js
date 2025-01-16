// vite.config.js
import {
    defineConfig
} from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
    root: 'src',
    plugins: [
        react({
            jsxRuntime: 'automatic', // Use the automatic runtime
        })
    ],
    server: {
        watch: {
            include: ['src/**/**'],
            exclude: ['node_modules']
        },
    },
    build: {
        manifest: true,
        emptyOutDir: false,
        rollupOptions: {
            input: {
                frontend: 'src/js/frontend.cjs',
                admin: 'src/js/admin.jsx',
            },
            output: {
                dir: 'dist',
                format: 'esm',
            },
        },
    },
    resolve: {
        alias: {
            '@': '/src'
        }
    },
    esbuild: {
        loader: 'jsx', // Ensure JSX files are processed correctly
        include: /\.jsx?$/, // Matches .js and .jsx files
    },
    // CSS options
    css: {},
})
