const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css');
mix.sass('resources/sass/app.scss', 'public/css').options({
    processCssUrls: false
}).copy(
    'node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.ttf',
    'public/webfonts/fa-regular-400.ttf'
).copy(
    'node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2',
    'public/webfonts/fa-regular-400.woff2'
).copy(
    'node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.ttf',
    'public/webfonts/fa-solid-900.ttf'
).copy(
    'node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.woff2',
    'public/webfonts/fa-solid-900.woff2'
);
mix.postCss('resources/css/light.css', 'public/css');
mix.postCss('resources/css/dark.css', 'public/css');