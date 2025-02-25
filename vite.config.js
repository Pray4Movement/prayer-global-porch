import { defineConfig } from "vite";

export default defineConfig({
  base: "./",
  build: {
    outDir: "pages/assets/js/dist", // Directory for build output relative to the config file
    emptyOutDir: true, // Empties the outDir on build
    rollupOptions: {
      input: ["pages/assets/js/src/components.js"],
      output: {
        entryFileNames: `assets/[name]-bundle.js`,
        chunkFileNames: `assets/[name]-bundle.js`,
        assetFileNames: `assets/[name].[ext]`,
      },
    },
  },
});
