import {defineConfig} from 'vite';
import { ViteMinifyPlugin } from 'vite-plugin-minify'
import { viteStaticCopy } from 'vite-plugin-static-copy'
import path from 'path'
export default defineConfig({
    plugins: [
        viteStaticCopy({
            targets: [
                {
                    src: 'App/assets/fonts/*',
                    dest: 'fonts',
                    rename: { stripBase: true },
                },
                {
                    src: 'App/assets/images/*',
                    dest: 'images/app/',
                    rename: { stripBase: true },
                },
            ],
        }),
        ViteMinifyPlugin({}),
    ],
    emptyOutDir: true,
    root: path.resolve(__dirname, 'src'), // Set the root directory for Vite
    build: {
        outDir: '../public', // Output directory for compiled assets
        rollupOptions: {
            input: {
                main: '/App/assets/js/index.js', // Main JavaScript entry point
                style: '/App/assets/scss/index.scss', // Main CSS entry point
            },
            output: {
                manualChunks: undefined,
                entryFileNames: "js/app.js",
                assetFileNames: "css/app.css",
            },
        },
    },
    optimizeDeps: { force: true, },
    css: {
        preprocessorOptions: {
            scss: {
                // Bootstrap 5.3 still uses @import internally; silence
                // deprecation warnings coming from node_modules only.
                quietDeps: true,
            },
        },
    },
    resolve: {
        alias: [
            {
                // this is required for the SCSS modules
                find: /^~(.*)$/,
                replacement: '$1',
            }
        ],
    },
});
