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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/bookmark.js', 'public/js').autoload({
        "jquery": [ '$', 'window.jQuery' ],
    })
    .js('resources/js/message.js', 'public/js').autoload({
        "jquery": [ '$', 'window.jQuery' ],
    })
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .postCss('resources/css/styles.css', 'public/css')
    .version()
    .disableNotifications();
