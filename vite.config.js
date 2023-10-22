import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import removeAttr from 'remove-attr'

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.tsx",
            refresh: true,
        }),
        react(),
        removeAttr({
            extensions: ['tsx'],
            attributes: ['data-dusk']
        })
    ],
});
