const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
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
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                main: {
                    'DEFAULT': '#FF9408',
                    '50': '#fffaf3',
                    '100': '#fff4e6',
                    '200': '#ffe4c1',
                    '300': '#ffd49c',
                    '400': '#ffb452',
                    '500': '#ff9408',
                    '600': '#e68507',
                    '700': '#bf6f06',
                    '800': '#995905',
                    '900': '#7d4904'
                },
                focus: {
                    'DEFAULT': '#facc15',
                    'error': '#dc3545'
                },
                backgroundImage: theme => ({
                    'fruits': "url('/images/frutas.jpg')",
                }),
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
