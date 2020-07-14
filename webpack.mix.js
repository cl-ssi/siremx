const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'resources/vendor/css/all.min.css',
    'resources/vendor/css/adminlte.min.css'
], 'public/css/sismamtheme.css')
.js('resources/js/app.js', 'public/js').sourceMaps() // JQuery, Bootstrap, VueJS
.scripts([
    'resources/vendor/js/adminlte.min.js',
    'resources/vendor/js/demo.js'
], 'public/js/sismamtheme.js')
.copy('resources/vendor/fontawesome/webfonts', 'public/webfonts')
.copy('resources/vendor/img', 'public/img')
.copy('resources/vendor/css/adminlte.min.css.map', 'public/css/adminlte.min.css.map')
.copy('resources/vendor/js/adminlte.min.js.map', 'public/js/adminlte.min.js.map');;
