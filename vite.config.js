import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js", // Untuk Admin
                "resources/scss/app.scss", // Untuk Admin
                "resources/js/market.js", // Untuk Market
                "resources/scss/market.scss", // Untuk Market
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            "~argon": path.resolve(__dirname, "resources/scss/argon-dashboard"),
        },
    },
});
