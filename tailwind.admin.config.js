import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/*
 * Musheeda ADMIN design system (used only by resources/css/admin.css).
 * The public site uses tailwind.config.js + resources/css/app.css.
 * ----------------------
 * - Neutrals: a warm graphite scale. It replaces `slate` and `gray` so every
 *   existing view picks up the same calm, paper-like tone.
 * - Brand: a deep pine green. It replaces `indigo` and `blue` as well, so
 *   stray off-palette accents fold into one colour.
 * - Radii and shadows are deliberately tighter/softer than Tailwind defaults.
 */

const neutral = {
    50: '#f7f7f5',
    100: '#efefec',
    200: '#e4e4df',
    300: '#d0d0c9',
    400: '#a3a39b',
    500: '#76766e',
    600: '#58584f',
    700: '#3f3f39',
    800: '#292925',
    900: '#1a1a17',
    950: '#10100e',
};

const brand = {
    50: '#eef6f2',
    100: '#d6ebe2',
    200: '#acd5c4',
    300: '#7bb9a2',
    400: '#4b9a80',
    500: '#2b7d64',
    600: '#1f6652',
    700: '#195243',
    800: '#154338',
    900: '#11372f',
    950: '#08201b',
};

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './resources/views/admin/**/*.blade.php',
        './resources/views/auth/**/*.blade.php',
        './resources/views/profile/**/*.blade.php',
        './resources/views/components/**/*.blade.php',
        './resources/views/layouts/admin.blade.php',
        './resources/views/layouts/guest.blade.php',
    ],

    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Instrument Serif"', 'Georgia', ...defaultTheme.fontFamily.serif],
            },
            fontSize: {
                'title-md2': ['1.5rem', { lineHeight: '2rem', letterSpacing: '-0.015em' }],
            },
            colors: {
                slate: neutral,
                gray: neutral,
                ink: neutral,
                brand,
                indigo: brand,
                blue: brand,
                success: {
                    DEFAULT: '#1f8a5b',
                    50: '#edf8f2',
                    100: '#d3efdf',
                    400: '#4cb383',
                    500: '#1f8a5b',
                    600: '#18704a',
                    700: '#135a3c',
                },
                error: {
                    DEFAULT: '#c2410c',
                    50: '#fdf3ee',
                    100: '#fbe2d6',
                    400: '#ea7a4c',
                    500: '#d9541f',
                    600: '#b9420f',
                    700: '#97360d',
                },
                warning: {
                    DEFAULT: '#b7791f',
                    50: '#fcf7ec',
                    100: '#f7eacb',
                    400: '#dcaa4a',
                    500: '#c98f27',
                    600: '#a8741b',
                    700: '#865c16',
                },
            },
            borderRadius: {
                xl: '0.625rem',
                '2xl': '0.75rem',
                '3xl': '1rem',
            },
            borderWidth: {
                6: '6px',
            },
            boxShadow: {
                sm: '0 1px 2px 0 rgb(16 16 14 / 0.04)',
                DEFAULT: '0 1px 3px 0 rgb(16 16 14 / 0.06), 0 1px 2px -1px rgb(16 16 14 / 0.04)',
                md: '0 4px 12px -4px rgb(16 16 14 / 0.08)',
                lg: '0 10px 24px -12px rgb(16 16 14 / 0.12)',
                xl: '0 16px 32px -16px rgb(16 16 14 / 0.16)',
                '2xl': '0 28px 56px -28px rgb(16 16 14 / 0.22)',
                'theme-sm': '0 1px 2px 0 rgb(16 16 14 / 0.04)',
                'theme-md': '0 4px 12px -4px rgb(16 16 14 / 0.08)',
                'theme-lg': '0 10px 24px -12px rgb(16 16 14 / 0.12)',
            },
            letterSpacing: {
                eyebrow: '0.14em',
            },
            screens: {
                '2xsm': '375px',
            },
        },
    },

    plugins: [forms],
};
