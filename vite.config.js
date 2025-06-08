import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';


export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,
    //     strictPort: true,
    //     hmr: {
    //         protocol: 'ws', // atau 'wss' jika pakai https
    //         host: '172.40.0.7', // ganti sesuai IP lokal kamu
    //         port: 5173, // pastikan sama
    //         clientPort: 5173
    //     }
    // },
});
