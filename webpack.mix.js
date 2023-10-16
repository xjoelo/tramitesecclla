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
mix.js('resources/js/app.js', 'public/js').version();;
mix.js('resources/js-virtual/app.js', 'public/js-virtual').vue();

mix.browserSync('http://tramite-secclla.xjoelo');

mix.webpackConfig({
  resolve: {
    alias: {
      '@': __dirname + '/resources/js',
      '@2': __dirname + '/resources/js-virtual'
    },
  },
})
