const mix = require('laravel-mix');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');



mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

    mix.webpackConfig({
        plugins: [
            new VuetifyLoaderPlugin(),
        ]
    }).sourceMaps();
