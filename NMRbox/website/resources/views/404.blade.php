<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>404 Error| Welcome to Chandra_Frontend</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="shortcut icon" href="{{ asset('assets/img/nmr-favicon/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- end of global css-->
    <!-- page level styles-->
    <!-- end of page level styles-->
</head>

<body>
    <div class="container">
        <h2>404 ERROR</h2>
        <a href="{{ route('home') }}">
            <button type="button" class="btn btn-responsive button-alignment btn-lg">Return to Home</button>
        </a>
    </div>
    <!-- global js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- end of global js -->
</body>

</html>
