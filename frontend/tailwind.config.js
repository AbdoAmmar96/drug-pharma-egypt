/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{js,jsx}',
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#1B2360',
          700: '#2A337A',
          900: '#11163F',
        },
        orange: {
          DEFAULT: '#E87330',
          700: '#C95A1B',
          200: '#FBE3D2',
        },
        bg: '#FAFAF7',
        line: '#E8E8EA',
      },
      fontFamily: {
        display: ['Outfit', 'system-ui', 'sans-serif'],
        body: ['DM Sans', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'soft':   '0 1px 2px rgba(27, 35, 96, 0.04), 0 2px 8px rgba(27, 35, 96, 0.04)',
        'card':   '0 4px 12px rgba(27, 35, 96, 0.06), 0 12px 32px rgba(27, 35, 96, 0.08)',
        'lifted': '0 10px 30px rgba(27, 35, 96, 0.10), 0 30px 60px rgba(27, 35, 96, 0.12)',
        'orange': '0 6px 20px rgba(232, 115, 48, 0.35)',
      },
      animation: {
        'float': 'float 6s ease-in-out infinite',
        'pulse-dot': 'pulseDot 2s ease-in-out infinite',
      },
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-12px)' },
        },
        pulseDot: {
          '0%, 100%': { opacity: '1', transform: 'scale(1)' },
          '50%': { opacity: '0.5', transform: 'scale(1.5)' },
        },
      },
    },
  },
  plugins: [],
}
