<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}">

    <title>Online Veggies</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('/')}}/frontend/css/style.css" type="text/css">

</head>

<body>
    <!-- Page Preloder -->

    <!-- Humberger Begin -->
    <!-- Humberger End -->
    
    <!-- Header Section Begin -->
    <!-- Header Section End -->
    <!-- Hero Section Begin -->
     <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
        @endforeach
    </div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @yield('content')
       
    <!-- Hero Section End -->

    <!-- Footer Section Begin -->
    @include('frontend.footer')
    
    <!-- Footer Section End -->
    <!-- Js Plugins -->
    <script src="{{ URL::to('/')}}/frontend/js/jquery-3.3.1.min.js"></script>
    <script src="{{ URL::to('/')}}/frontend/js/bootstrap.min.js"></script>
    <script src="{{ URL::to('/')}}/frontend/js/jquery.nice-select.min.js"></script>
    <script src="{{ URL::to('/')}}/frontend/js/jquery-ui.min.js"></script>
    <script src="{{ URL::to('/')}}/frontend/js/jquery.slicknav.js"></script>
    <script src="{{ URL::to('/')}}/frontend/js/mixitup.min.js"></script>
    <script src="{{ URL::to('/')}}/frontend/js/owl.carousel.min.js"></script>
    <script src="{{ URL::to('/')}}/frontend/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    
    @yield('javascript')

</body>

</html>