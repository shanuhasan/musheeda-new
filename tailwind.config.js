import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#ecf3ff',
                    100: '#dde9ff',
                    200: '#c2d6ff',
                    300: '#9cb9ff',
                    400: '#7592ff',
                    500: '#465fff',
                    600: '#3641f5',
                    700: '#2a31d8',
                    800: '#252dae',
                    900: '#262e89',
                    950: '#161950',
                },
                success: {
                    50: '#ecfdf3',
                    100: '#d1fadf',
                    400: '#32d583',
                    500: '#12b76a',
                    600: '#039855',
                },
                error: {
                    50: '#fef3f2',
                    100: '#fee4e2',
                    400: '#f97066',
                    500: '#f04438',
                    600: '#d92d20',
                },
                warning: {
                    50: '#fffaeb',
                    100: '#fef0c7',
                    400: '#fdb022',
                    500: '#f79009',
                    600: '#dc6803',
                }
            },
            boxShadow: {
                'theme-sm': '0px 1px 3px 0px rgba(16, 24, 40, 0.1), 0px 1px 2px 0px rgba(16, 24, 40, 0.06)',
                'theme-md': '0px 4px 8px -2px rgba(16, 24, 40, 0.1), 0px 2px 4px -2px rgba(16, 24, 40, 0.06)',
                'theme-lg': '0px 12px 16px -4px rgba(16, 24, 40, 0.08), 0px 4px 6px -2px rgba(16, 24, 40, 0.03)',
            }
        },
    },

    plugins: [forms],
};
