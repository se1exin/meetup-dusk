const { mix } = require('laravel-mix');


mix.js('resources/assets/js/main.js', 'public/js')
    .less('resources/assets/less/common.less', 'public/css')
    .less('resources/assets/less/simple.less', 'public/css');