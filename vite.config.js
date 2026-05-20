import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // Atau plugin tailwind yang kamu pakai

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0', // Agar bisa diakses dari jaringan luar
        port: 5173,      // Port default Vite
        strictPort: true,
        hmr: {
            protocol: 'wss', // Penting: Gunakan Secure WebSocket untuk ngrok
            host: 'https://startup-magnetize-symphonic.ngrok-free.dev', // GANTI dengan link ngrok punyamu
        },
    },
});