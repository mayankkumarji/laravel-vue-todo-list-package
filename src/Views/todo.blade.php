<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('todo/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <v-app id="inspire">
            <navbar inline-template>
                <topbar />
            </navbar>
        </v-app>
       
    </div>

    <!-- Scripts -->
    <script src="{{ asset('todo/js/app.js') }}"></script>
</body>
</html>
