let mix = require('laravel-mix');

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

mix.options({
  processCssUrls: false
});

mix.sass('resources/assets/sass/app.scss', 'public/css')
    .babel([
      'resources/assets/js/site.js',
    ], 'public/js/site.js');
