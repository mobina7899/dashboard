<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>
        @section('pagetitle') - Bootstrap 4 Admin Dashboard Template
        @show
    </title>

    <link href="{{asset('/fullcalendar/main.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>


    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Plugins Core Css -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link href="{{ asset('/css/dashboard/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/dashboard/materialize-rtl.min.css') }}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('/css/dashboard/style.css') }}" rel="stylesheet">
    <!-- You can choose a theme from css/styles instead of get all themes -->
    <link href="{{ asset('/css/dashboard/all-themes.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/dashboard/multi-select.css') }}" rel="stylesheet">

</head>
