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

mix.config.babelConfig = {
    presets: [
        'babel-preset-env',
    ],
    plugins: ['babel-plugin-syntax-dynamic-import'],
};

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/assets/spa/'),
        },
    }
});

mix.js('resources/assets/spa/main.js', 'public/spa')
    .sourceMaps()
    .browserSync('homestead.test/timetable');
