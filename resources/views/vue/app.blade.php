<!DOCTYPE html>

<html>

<head>
    <title>PetLovers Admin</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="theme-color" content="#c62828">
    {{--<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />--}}
</head>

<body>
<div id="app">
</div>
<!-- Content End Here -->

<footer>
    {{--@include('admin.layout.scripts')--}}
    <script src="{{ mix('vue/js/app.js') }}"></script>
</footer>

</body>

</html>