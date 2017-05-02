const { mix } = require('laravel-mix');


mix.js('resources/assets/js/register.js', 'public/js')
    .scripts([
        'resources/assets/js/payform.js',
        'resources/assets/js/payment.js'
    ], 'public/js/payment.js')
    .less('resources/assets/less/common.less', 'public/css')
    .less('resources/assets/less/simple.less', 'public/css')
    .less('resources/assets/less/advanced.less', 'public/css');