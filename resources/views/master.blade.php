<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:300,600" rel="stylesheet" type="text/css">
        <link href="/css/common.css" rel="stylesheet" type="text/css">
        @yield('extra_css')
    </head>
    <body>
        <div id="main">
            @yield('content')
        </div>

        @yield('extra_js')
    </body>
</html>
