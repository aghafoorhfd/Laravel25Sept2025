const mix = require('laravel-mix');

// Admin
// mix.webpackConfig({
//     output: {
//         path:__dirname+'/public/dist/admin',
//     }
// });
mix.setPublicPath('public/dist/admin');
mix.setResourceRoot('../');

mix.sass('resources/admin/scss/vendors.scss', 'css')
    .sass('resources/admin/scss/app.scss', 'css').sourceMaps(true);

mix.js('resources/admin/js/app.js','js').extract([]);
mix.js('resources/admin/js/frontend_lectures.js','js');
