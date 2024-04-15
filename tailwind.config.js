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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                fondobotonazul: '#23325A',                   
                fondobotonnaranja: '#E7A572',                   
                fondoclaro: '#F7E6D3',                   
                fondobotonrojo: '#792B43', 
                fondofosrastero: '#97A9A9', 

              },
        },       
    },

    plugins: [forms, typography],
    darkMode: 'class',
};
