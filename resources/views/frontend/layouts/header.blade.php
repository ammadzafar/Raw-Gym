<header class="main-header header-style-one">

    <!--Header-Upper-->
    <div class="header-upper">
        <div class="outer-container">
            <div class="inner-container clearfix">

                <!-- Logo Box -->
                <div class="logo-box">
                    <div class="logo"><a href="{{ url('/') }}"><img src="{{ asset('images/logo-light-lg.png') }}" alt=""
                                                                title=""></a></div>
                </div>

                <!-- Logo -->
                <div class="mobile-logo">
                    <a href="{{ url('/') }}" title=""><img src="{{ asset('images/logo-light-sm.png') }}" alt="" title=""></a>
                </div>

                <!-- Header Social Box -->
                <div class="header-social-box clearfix">
                    <a href="https://www.facebook.com/MuscleBar2021" target="_blank" class="fa fa-facebook"></a>
{{--                    <a href="#" class="fa fa-twitter"></a>--}}
{{--                    <a href="#" class="fa fa-instagram"></a>--}}
{{--                    <a href="#" class="fa fa-linkedin"></a>--}}
                </div>

                <div class="outer-box clearfix">

                    <!-- Hidden Nav Toggler -->
                    <div class="nav-toggler">
                        <div class="nav-btn">
                            <button class="hidden-bar-opener">Menu</button>
                        </div>
                    </div>
                    <!-- / Hidden Nav Toggler -->

                </div>

                <div class="nav-outer clearfix">
                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler"><span class="icon"><img
                                src="{{ asset('frontend/assets/images/icons/burger.svg') }}" alt=""/></span></div>
                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md">
                        <div class="navbar-header">
                            <!-- Toggle Button -->
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li><a href="#">Home</a></li>
                                <li><a href="#services_section">Services</a></li>
                                <li><a href="#aboutus_section">About Us</a></li>
                                <li><a href="#pricing_section">Pricing</a></li>
                                <li><a href="#trainers_section">Trainers</a></li>
                            </ul>
                        </div>

{{--                        <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">--}}
{{--                            <ul class="navigation clearfix">--}}
{{--                                <li><a href="{{ url('/') }}">Home</a></li>--}}
{{--                                <li class="dropdown"><a href="#">About Us</a>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="about.html">About Us</a></li>--}}
{{--                                        <li><a href="timetable.html">Time Table</a></li>--}}
{{--                                        <li><a href="commingsoon.html">Comming Soon</a></li>--}}
{{--                                        <li><a href="body-builder.html">Section Page 01</a></li>--}}
{{--                                        <li><a href="body-builder-2.html">Section Page 02</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li class="dropdown"><a href="#">Trainers</a>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="trainer.html">Trainer 01</a></li>--}}
{{--                                        <li><a href="trainer-2.html">Trainer 02</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li class="dropdown"><a href="#">Shop</a>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="shop-left.html">Shop Left Sidebar</a></li>--}}
{{--                                        <li><a href="shop-right.html">Shop Right Sidebar</a></li>--}}
{{--                                        <li><a href="shop-single.html">Product Single</a></li>--}}
{{--                                        <li><a href="shopping-cart.html">Shopping Cart</a></li>--}}
{{--                                        <li><a href="checkout.html">Checkout</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li class="dropdown"><a href="#">Blog</a>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="blog.html">Our Blog</a></li>--}}
{{--                                        <li><a href="blog-classic.html">Blog Classic</a></li>--}}
{{--                                        <li><a href="blog-detail.html">Blog Detail One</a></li>--}}
{{--                                        <li><a href="blog-detail-two.html">Blog Detail Two</a></li>--}}
{{--                                        <li><a href="not-found.html">Not Found</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li><a href="contact.html">Contact us</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </nav>

                </div>

            </div>

        </div>
    </div>
    <!--End Header Upper-->

    <!-- Sticky Header  -->
    <div class="sticky-header">
        <div class="auto-container clearfix">
            <!--Logo-->
            <div class="logo pull-left">
                <a href="{{ url('/') }}" title=""><img src="{{ asset('images/logo-light-lg.png') }}"  alt="" title=""></a>
            </div>
            <!--Right Col-->
            <div class="pull-right">
                <!-- Main Menu -->
                <nav class="main-menu">
                    <!--Keep This Empty / Menu will come through Javascript-->
                </nav><!-- Main Menu End-->

            </div>
        </div>
    </div><!-- End Sticky Menu -->

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn"><span class="icon flaticon-multiply"></span></div>

        <nav class="menu-box">
            <div class="nav-logo"><a href="{{ url('/') }}"><img src="{{ asset('images/logo-light-lg.png') }}" alt=""
                                                            title=""></a></div>
            <div class="menu-outer">
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
        </nav>

    </div>
    <!-- End Mobile Menu -->

</header>
