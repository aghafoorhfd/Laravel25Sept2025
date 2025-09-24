const mix = require('laravel-mix');

mix.setPublicPath('public/dist/frontend');

mix.sass('public/sass/app.scss','css');
mix.sass('public/sass/contact.scss','css');
// ----------------------------------------------------------------------------------------------------
//Booking
mix.sass('public/module/booking/scss/checkout.scss','module/booking/css');
mix.sass('public/module/user/scss/user.scss','module/user/css');
mix.sass('public/module/user/scss/profile.scss','module/user/css');
mix.sass('public/module/news/scss/news.scss','module/news/css');
mix.sass('public/module/media/scss/browser.scss','module/media/css');
mix.sass('public/module/course/css/course.scss','module/course2/css').options({
    processCssUrls: false,
    postCss: [
        require('autoprefixer')({
            overrideBrowserslist: ['last 10 versions'],
        })
    ]


});;
mix.sass('public/module/course/css/header.scss','module/course2/css').options({
    processCssUrls: false
});;
mix.sass('public/module/course/scss/study.scss','module/course2/css').options({
    processCssUrls: false
});;
