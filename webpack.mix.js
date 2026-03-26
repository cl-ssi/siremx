const mix = require('laravel-mix');
const webpack = require('webpack');

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

//mix.setPublicPath('public/sismam')

mix.styles([
    'resources/vendor/css/all.min.css',
    'resources/vendor/css/adminlte.min.css',
    'resources/vendor/css/config.css'
], 'public/css/sismamtheme.css')
    .js('resources/js/app.js', 'public/js').vue({
        version: 3,
        options: {
            compilerOptions: {
                whitespace: 'condense',  // ← agrega esta línea
                compatConfig: {
                    MODE: 2
                }
            }
        }
    }) //.sourceMaps() // JQuery, Bootstrap, VueJS
    .scripts([
        'resources/vendor/js/adminlte.min.js',
        'resources/vendor/js/demo.js'
    ], 'public/js/sismamtheme.js')
    .copy('resources/vendor/fontawesome/webfonts', 'public/webfonts')
    .copy('resources/vendor/img', 'public/img')
    .copy('resources/vendor/css/adminlte.min.css.map', 'public/css/adminlte.min.css.map')
    .copy('resources/vendor/js/adminlte.min.js.map', 'public/js/adminlte.min.js.map');

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false,
            __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
        })
    ]
});
