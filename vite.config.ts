import { execSync } from 'node:child_process';
import { existsSync } from 'node:fs';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

const hasPhpBinary = (() => {
    try {
        execSync('php --version', { stdio: 'ignore' });

        return true;
    } catch {
        return false;
    }
})();

const shouldGenerateWayfinderTypes =
    hasPhpBinary && existsSync('artisan') && existsSync('vendor/autoload.php');

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        svelte(),
        ...(shouldGenerateWayfinderTypes
            ? [
                  wayfinder({
                      formVariants: true,
                  }),
              ]
            : []),
    ],
});
