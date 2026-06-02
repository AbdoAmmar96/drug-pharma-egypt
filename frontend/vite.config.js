import { defineConfig, loadEnv } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')

  return {
    plugins: [react()],
    server: {
      port: 5173,
      // Proxy API calls + asset paths to Laravel during dev to avoid CORS hassle
      proxy: {
        '/api': {
          target: env.VITE_API_BASE || 'http://localhost:8000',
          changeOrigin: true,
          secure: false,
        },
        '/images': {
          target: env.VITE_API_BASE || 'http://localhost:8000',
          changeOrigin: true,
          secure: false,
        },
        '/storage': {
          target: env.VITE_API_BASE || 'http://localhost:8000',
          changeOrigin: true,
          secure: false,
        },
      },
    },
    build: {
      outDir: 'dist',
      sourcemap: false,
    },
  }
})
