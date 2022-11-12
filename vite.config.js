import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
    	hmr: {
	    host: '127.0.0.1',
	}
    },
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/js/app.css'],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        }),
    ]
});
