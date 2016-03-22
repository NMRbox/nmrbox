<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>500 Internal Error| Welcome to Chandra_Frontend</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-3.3.4-dist/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="{{ asset('assets/css/frontend/404.css') }}" rel="stylesheet">
    <!-- end of page level styles-->
    </head>
<body>
    <div class="container">
        <div class="err-cont">
            <div class="col-sm-6 col-xs-6">
                <img src="{{ asset('assets/images/500err2.png') }}" class="img-responsive">
                <a href="{{ route('home') }}">
                    <button type="button" class="btn btn-responsive button-alignment" style="margin-bottom:7px;">Go Home</button>
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