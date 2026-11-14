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
                // Tokens Neo-Bento Pastel Palette
                background: '#F7F6FA',
                surface: {
                    DEFAULT: '#FFFFFF',
                    subtle: '#F0EFF8',
                    card: '#FFFFFF',
                    container: '#F3F2FA',
                    'container-high': '#E7E5F4',
                    'container-low': '#FFFFFF',
                },
                'surface-subtle': '#F0EFF8',
                primary: {
                    DEFAULT: '#7C73E6',
                    dark: '#685ED4',
                    light: '#F0EFFE',
                    fixed: '#7C73E6',
                    hover: '#685ED4',
                },
                'primary-dark': '#685ED4',
                'primary-light': '#F0EFFE',
                secondary: {
                    DEFAULT: '#7DD3FC',
                    light: '#F0F9FF',
                    container: '#38BDF8',
                },
                'secondary-light': '#F0F9FF',
                'status-available': {
                    DEFAULT: '#34D399',
                    subtle: '#ECFDF5',
                },
                'status-available-subtle': '#ECFDF5',
                'status-pending': {
                    DEFAULT: '#FBBF24',
                    subtle: '#FFFBEB',
                },
                'status-pending-subtle': '#FFFBEB',
                'status-unavailable': {
                    DEFAULT: '#FB7185',
                    subtle: '#FFF1F2',
                },
                'status-unavailable-subtle': '#FFF1F2',
                'border-subtle': '#E7E5F4',
                outline: '#A6A3BE',
                'on-surface': {
                    DEFAULT: '#1E1B4B',
                    variant: '#5C6079',
                },
                'on-surface-variant': '#5C6079',

                // Suavizado pastel de clases auxiliares de Tailwind para coherencia total
                indigo: {
                    50: '#F0EFFE',
                    100: '#E4E2FD',
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
                '2xl': '1.25rem',
                '3xl': '1.75rem',
            },
            boxShadow: {
                'bento': '0 4px 20px -2px rgba(124, 115, 230, 0.08), 0 2px 6px -1px rgba(30, 27, 75, 0.03)',
                'bento-glow': '0 8px 30px -4px rgba(124, 115, 230, 0.20)',
                'glass': '0 8px 32px 0 rgba(124, 115, 230, 0.08)',
            },
        },
    },

    plugins: [forms, typography],
    darkMode: 'class',
};
