@extends('frontend.layouts.master')

@section('content')
    <!-- FullScreen Menu -->
    <div class="fullscreen-menu">
        <!--Close Btn-->
        <div class="close-menu"><span>Close</span></div>

        <div class="menu-outer-container">
            <div class="menu-box">
                <nav class="full-menu">
                    <ul class="navigation">
                        <li><a href="index.html">Home</a></li>
                        <li class="current dropdown"><a href="#">About Us</a>
                            <ul>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="timetable.html">Time Table</a></li>
                                <li><a href="commingsoon.html">Comming Soon</a></li>
                                <li><a href="body-builder.html">Section Page 01</a></li>
                                <li><a href="body-builder-2.html">Section Page 02</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#">Trainers</a>
                            <ul>
                                <li><a href="trainer.html">Trainer 01</a></li>
                                <li><a href="trainer-2.html">Trainer 02</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#">Shop</a>
                            <ul>
                                <li><a href="shop-left.html">Shop Left Sidebar</a></li>
                                <li><a href="shop-right.html">Shop Right Sidebar</a></li>
                                <li><a href="shop-single.html">Product Single</a></li>
                                <li><a href="shopping-cart.html">Shopping Cart</a></li>
                                <li><a href="checkout.html">Checkout</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#">Blog</a>
                            <ul>
                                <li><a href="blog.html">Our Blog</a></li>
                                <li><a href="blog-classic.html">Blog Classic</a></li>
                                <li><a href="blog-detail.html">Blog Detail One</a></li>
                                <li><a href="blog-detail-two.html">Blog Detail Two</a></li>
                                <li><a href="not-found.html">Not Found</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact us</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- End FullScreen Menu -->

    <!--Page Title-->
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x408)">
        <div class="auto-container">
            <h2>ABOUT US</h2>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>About Us</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->
@endsection
