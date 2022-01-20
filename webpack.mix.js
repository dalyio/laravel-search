const mix = require('laravel-mix');
const glob = require('glob');

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

mix.webpackConfig({
    devtool: 'source-map'
});

mix.combine([
    'resources/assets/sass/app/*.scss'
], 'resources/assets/sass/app.scss');

mix.combine([
    'resources/assets/js/*.js'
], 'public/js/app.js');

mix.combine([
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'node_modules/bootstrap-select/dist/css/bootstrap-select.css',
    'node_modules/bootstrap-slider/dist/css/bootstrap-slider.css',
    'node_modules/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css',
    'node_modules/font-awesome/css/font-awesome.css',
    'node_modules/daterangepicker/daterangepicker.css',
    'node_modules/highcharts/css/highcharts.css'
], 'public/css/vendor.css').sourceMaps(true, 'source-map');

mix.scripts([
    'node_modules/lodash/lodash.min.js',
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    'node_modules/bootstrap-select/dist/js/bootstrap-select.js',
    'node_modules/bootstrap-slider/dist/bootstrap-slider.js',
    'node_modules/bootstrap-switch/dist/js/bootstrap-switch.js',
    'node_modules/bootpag/lib/jquery.bootpag.js',
    'node_modules/moment/min/moment.min.js',
    'node_modules/moment-timezone/builds/moment-timezone-with-data.min.js',
    'node_modules/daterangepicker/daterangepicker.js',
    'node_modules/vue/dist/vue.global.prod.js',
    'node_modules/highcharts/highcharts.js'
], 'public/js/vendor.js').sourceMaps(true, 'source-map');

glob.sync('resources/assets/sass/*.scss').forEach((path) => {
    mix.sass(path, 'css/');
});

mix.copy([
    'node_modules/font-awesome/fonts',
    'node_modules/summernote/dist/font'
], 'public/fonts');

mix.copy([
    'node_modules/highcharts/highcharts.js.map',
], 'public/js');
