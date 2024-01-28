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
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', 'sans-serif'], // Добавляем 'Roboto' в качестве основного шрифта
            },
            textColor: {
                DEFAULT: '#FF0000',
            },
            // Расширение существующих цветов
            colors: {
                'background-1': '#F4F4FA',
                'background-2': '#FAFAFF',
                'header-1': '#D8D8F4',
                'header-2': '#E6E6F5',
                'text-color': '#232330',
                'button-color': '#2A8BF2',
                'button-color-green': '#4CAF50',
            },
        },
    },

    plugins: [forms, typography],
};
