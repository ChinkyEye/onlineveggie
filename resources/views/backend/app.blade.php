<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Smart Veggies | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <link rel="stylesheet" href="{{url('/')}}/backend/css/all.min.css">
    
    <!-- select2 -->
    <link rel="stylesheet" href="{{url('/')}}/backend/css/select2.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url('/')}}/backend/css/icheck-bootstrap.min.css">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('/')}}/backend/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{url('/')}}/backend/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{url('/')}}/backend/css/daterangepicker.css">
    <link rel="stylesheet" href="{{url('/')}}/backend/pace-progress/themes/black/pace-theme-flat-top.css">
    <link rel="stylesheet" href="{{url('/')}}/backend/css/style.main.css">
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('backend.nav-bar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header pt-2 pb-1">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <?php $change = array("admin-","-", "_"); ?>
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark text-capitalize">{{str_replace($change,' ',Route::currentRouteName())}}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{url('/')}}/backend">Home</a></li>
                                <li class="breadcrumb-item text-capitalize active">{{str_replace($change,' ',Route::currentRouteName())}}</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
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
                <!-- Main content -->
                    @yield('content')
                <!-- /.content -->
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
        @include('backend.footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{url('/')}}/backend/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{url('/')}}/backend/js/bootstrap.bundle.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{url('/')}}/backend/js/moment.min.js"></script>
    <script src="{{url('/')}}/backend/js/daterangepicker.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{url('/')}}/backend/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{url('/')}}/backend/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{url('/')}}/backend/pace-progress/pace.js"></script>
    <!-- imagePreview -->
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
    </script>
    <script type="text/javascript">
        $('form').submit(function(event) {
            $(this).find("button[type='submit']").prop('disabled',true);
        });
    </script>
    <script type="text/javascript">
        $(".rotate").click(function () {
            $(this).toggleClass("down");
        });
    </script>
    <script type="text/javascript">
        function PrintDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <script type="text/javascript">
        $('.fade').on('shown.bs.modal', function () {
            $('#name').focus();
        })
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#date').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                // showDropdowns : true,
                startDate : true,
            locale:{
                format: 'YYYY/MM/DD',
                cancleLabel: 'clear',
            },
        }).on("apply.daterangepicker", function (e, picker) {
        picker.element.val(picker.startDate.format(picker.locale.format));
    });
        $('#date1').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                // showDropdowns : true,
                startDate : true,
            locale:{
                format: 'YYYY/MM/DD',
                cancleLabel: 'clear',
            },
        }).on("apply.daterangepicker", function (e, picker) {
        picker.element.val(picker.startDate.format(picker.locale.format));
    });
    $('.modal').modal({
        show:false,
        keyboard: true,
        backdrop: 'static'
    });
});
</script>
<script type="text/javascript">
    // $('.nav-link').on('click', function(){
    //     $('.nav-link').toggleClass('active');
    // })
  </script>
    @yield('javascript')


    <script type="text/javascript">
        $('#read-data').on('click',function(){
            $.get("{{URL::to('manager/slider/getAllData')}}", function(data){
                // console.log(data); 
                $('#user').empty().html(data);
                // $.each(data,function(i,value){
                //     var tr =$("<tr/>");
                //     tr.append($("<td/>",{
                //         text : value.id
                //     })).append($("<td/>",{
                //         text : value.title
                //     })).append($("<td/>",{
                //         text : value.image
                //     })).append($("<td/>",{
                //         text : value.image
                //     })).append($("<td/>",{
                //         text : value.image
                //     })).append($("<td/>",{
                //         html : "<a href='#'>View</a> | <a href='#'>Delete</a>"
                //     }))
                //     $('#user').append(tr);
                // });
            })
        })
    </script>
    
</body>
</html>