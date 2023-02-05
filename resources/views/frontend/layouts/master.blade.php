
<!DOCTYPE html>
<html>
@include('frontend.layouts.head')

<body class="hidden-bar-wrapper">

<div class="page-wrapper">

    <!-- Preloder -->
    <div id="preloder" class="preloader">
        <div class="loader"></div>
    </div>
    <!-- Εnd Preloader -->

    <!-- Main Header-->
@include('frontend.layouts.header')
<!-- End Main Header -->

    <!-- FullScreen Menu -->
@include('frontend.layouts.full-screen-menu')
<!-- End FullScreen Menu -->

@yield('content')

<!-- Main Footer -->
    @include('frontend.layouts.footer')

</div>
<!--End pagewrapper-->

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>

<!-- Purchase Popup -->
@include('frontend.layouts.purchase-popup')

@include('frontend.layouts.footer-scripts')

</body>
</html>
