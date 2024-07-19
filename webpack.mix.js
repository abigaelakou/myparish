/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 19/07/2024 - 10:53:28
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 19/07/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
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
    .postCss('resources/css/app.css', 'public/css', [
        //
        require('postcss-import'),
        require('tailwindcss'),
    ]);