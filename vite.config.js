import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server:{
        hmr:{
            host: 'localhost'
        },
        host: true,
        port: 3000
    },
    define: {
        'process.env.SUPABASE_URL': JSON.stringify(process.env.SUPABASE_URL),
        'process.env.SUPABASE_KEY': JSON.stringify(process.env.SUPABASE_KEY),
    }
    
});
