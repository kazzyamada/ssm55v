<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!--
        <link rel="stylesheet" href="{{ mix('css/app.css') }}"></script>
            -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">


        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            window.Laravel = {
                csrfToken: "{{ csrf_token() }}"
            };
        </script>
    </head>
    <body>
        <div id="app">
            <navbar></navbar>
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
    </body>
    <script src="{{ mix('js/app.js') }}"></script>
</html>

