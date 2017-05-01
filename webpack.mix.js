const { mix } = require('laravel-mix');


mix.js('resources/assets/js/app.js', 'public/js')
    .combine(['public/js/main.js'], 'public/js/main.js')
    .less('resources/assets/less/common.less', 'public/css')
    .less('resources/assets/less/simple.less', 'public/css');