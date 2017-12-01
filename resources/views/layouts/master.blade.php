<!DOCTYPE html>
<html>
<head>

  <title>Aria</title>

  <meta name="viewport" content="width=device-width" />

  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery-ui.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-datepicker.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/fonts/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/fonts.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollbar-style.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/user-profile.css').'?'.rand()}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/band-profile.css').'?'.rand()}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css').'?'.rand()}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/modal.css').'?'.rand()}}">


</head>

<body>

@yield('content')


</body>

</html>