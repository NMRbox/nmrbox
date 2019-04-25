<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>500 Internal Error| Welcome to Chandra_Frontend</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/nmr-favicon/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="{{ asset('assets/css/frontend/500.css') }}" rel="stylesheet" type="text/css">
    <!-- end of page level styles-->
    </head>
<body>
    <div class="container">
        <div class="err-cont">
            <div class="col-sm-6 col-xs-6">
                <img src="{{ asset('assets/images/500-bg.png') }}" class="img-responsive animated bounceInLeft">
                <h1> 500 Error</h1>
                <a href="{{ route('home') }}">
                    <button type="button" class="btn btn-responsive button-alignment btn-lg">Go Home</button>
                </a>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- end of global js -->
</body>
</html>