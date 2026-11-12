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
                // Tokens Dark Command Center (eBand 3.1.0)
                surface: {
                    DEFAULT: '#0B1120',
                    page: '#0B1120',
                    card: '#111827',
                    container: '#1E293B',
                    'container-high': '#334155',
                    'container-low': '#0F172A',
                },
                primary: {
                    DEFAULT: '#2563EB',
                    fixed: '#1D4ED8',
                    hover: '#1D4ED8',
                },
                secondary: {
                    DEFAULT: '#F59E0B',
                    container: '#D97706',
                },
                'status-available': {
                    DEFAULT: '#10B981',
                    subtle: 'rgba(16, 185, 129, 0.15)',
                },
                'status-pending': {
                    DEFAULT: '#F59E0B',
                    subtle: 'rgba(245, 158, 11, 0.15)',
                },
                'status-unavailable': {
                    DEFAULT: '#F43F5E',
                    subtle: 'rgba(244, 63, 94, 0.15)',
                },
                'border-subtle': '#1E293B',
                'on-surface': {
                    DEFAULT: '#F8FAFC',
                    variant: '#94A3B8',
                },

                // Colores heredados (mantiene compatibilidad completa con vistas previas)
                fondobotonazul: '#23325A',
                fondobotonnaranja: '#E7A572',
                fondoclaro: '#cbcbcb',
                fondobotonrojo: '#792B43',
                fondofosrastero: '#97A9A9',
                azulfechas: '#2F445F',
            },
            borderRadius: {
                '2xl': '1rem',
            },
        },
    },

    plugins: [forms, typography],
    darkMode: 'class',
};
