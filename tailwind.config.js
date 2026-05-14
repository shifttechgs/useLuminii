import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Geist', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                luminii: {
                    navy: '#081D3A',
                    deepNavy: '#040F1F',
                    gold: '#F5C542',
                    deepGold: '#D9A441',
                    goldTint: '#FFF4C2',
                    muted: '#647082',
                    bg: '#F8F9FC',
                    border: '#E5EAF2',
                },
            },
            borderRadius: {
                luminii: '16px',
                'luminii-lg': '24px',
            },
        },
    },
    plugins: [],
};
