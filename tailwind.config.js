import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                headline: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Tokens Neo-Bento Violet (eBand 3.1.0)
                background: '#F5F6FC',
                surface: {
                    DEFAULT: '#FFFFFF',
                    subtle: '#EEF1FA',
                    card: '#FFFFFF',
                    container: '#F1F4FD',
                    'container-high': '#E2E8F0',
                    'container-low': '#FFFFFF',
                },
                'surface-subtle': '#EEF1FA',
                primary: {
                    DEFAULT: '#4F46E5',
                    dark: '#4338CA',
                    light: '#EEF2FF',
                    fixed: '#4F46E5',
                    hover: '#4338CA',
                },
                'primary-dark': '#4338CA',
                'primary-light': '#EEF2FF',
                secondary: {
                    DEFAULT: '#06B6D4',
                    light: '#ECFEFF',
                    container: '#0891B2',
                },
                'secondary-light': '#ECFEFF',
                'status-available': {
                    DEFAULT: '#10B981',
                    subtle: '#ECFDF5',
                },
                'status-available-subtle': '#ECFDF5',
                'status-pending': {
                    DEFAULT: '#F59E0B',
                    subtle: '#FFFBEB',
                },
                'status-pending-subtle': '#FFFBEB',
                'status-unavailable': {
                    DEFAULT: '#F43F5E',
                    subtle: '#FFF1F2',
                },
                'status-unavailable-subtle': '#FFF1F2',
                'border-subtle': '#E2E8F0',
                outline: '#94A3B8',
                'on-surface': {
                    DEFAULT: '#0F172A',
                    variant: '#475569',
                },
                'on-surface-variant': '#475569',

                // Colores heredados (mantiene compatibilidad completa con vistas previas)
                fondobotonazul: '#23325A',
                fondobotonnaranja: '#E7A572',
                fondoclaro: '#cbcbcb',
                fondobotonrojo: '#792B43',
                fondofosrastero: '#97A9A9',
                azulfechas: '#2F445F',
            },
            borderRadius: {
                '2xl': '1.25rem',
                '3xl': '1.75rem',
            },
            boxShadow: {
                'bento': '0 4px 20px -2px rgba(79, 70, 229, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03)',
                'bento-glow': '0 8px 30px -4px rgba(79, 70, 229, 0.16)',
                'glass': '0 8px 32px 0 rgba(79, 70, 229, 0.08)',
            },
        },
    },

    plugins: [forms, typography],
    darkMode: 'class',
};
