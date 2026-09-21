import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/livewire/livewire/src/**/*.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                navy:  '#3A115E',
                'navy-dark': '#1E0730',
                'navy-mid': '#2B0C47',
                teal:  '#8D38C9',
                'teal-dark': '#7027A0',
                gold:  '#C4996C',
                'gold-light': '#DDBF9A',
                'gold-dim': 'rgba(196,153,108,0.2)',
                'off': '#F7F8FA',
                'muted': '#6B7280',
                'border-gray': '#E5E7EB',
            },
            fontFamily: {
                sans: ['Sarabun', ...defaultTheme.fontFamily.sans],
                prompt: ['Prompt', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(135deg, #1E0730 0%, #3A115E 50%, #8D38C9 100%)',
                'stats-gradient': 'linear-gradient(135deg, #3A115E, #8D38C9)',
                'footer-gradient': 'linear-gradient(135deg, #1E0730, #3A115E)',
            },
            boxShadow: {
                'card': '0 2px 16px rgba(0,0,0,0.07)',
                'card-hover': '0 8px 32px rgba(0,0,0,0.12)',
                'gold': '0 8px 24px rgba(196,153,108,0.4)',
                'teal': '0 6px 24px rgba(141,56,201,0.12)',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.4s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },
        },
    },
    plugins: [],
};
