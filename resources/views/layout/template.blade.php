
<!DOCTYPE html>


<html lang="en">

<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>Trip</title>
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <link href="{{asset('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="{{asset('assets/demo/demo11/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="assets/demo/demo11/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

    <!--end::Global Theme Styles -->

</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m-content--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">



    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">


        <div class="m-grid__item m-grid__item--fluid m-wrapper">



            <!-- BEGIN: Subheader -->

        @yield('content')




        </div>
    </div>

    <!-- end:: Body -->


</div>

<!-- end:: Page -->







<!--begin::Global Theme Bundle -->
<script src="{{asset('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/demo/demo11/base/scripts.bundle.js')}}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->
</body>

<!-- end::Body -->
</html>
