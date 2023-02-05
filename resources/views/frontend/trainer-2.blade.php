@extends('frontend.layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x1080)">
        <div class="auto-container">
            <h2>OUR TRAINERS</h2>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Arnold Reshford</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Sidebar Page Container -->
    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Content Side -->
                <div class="content-side col-lg-9 col-md-12 col-sm-12">
                    <div class="trainer-detail style-two">
                        <div class="inner-box">
                            <div class="row clearfix">
                                <!-- Column -->
                                <div class="column col-lg-6 col-md-6 col-sm-12">
                                    <div class="image">
                                        <img src="https://via.placeholder.com/271x395" alt=""/>
                                    </div>
                                </div>
                                <!-- Column -->
                                <div class="column col-lg-6 col-md-6 col-sm-12">
                                    <div class="title-box">
                                        <h3>DONALD <br> RESHFORD</h3>
                                        <div class="category">Specialty: <span>Bodybuilding</span></div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                                        culpa qui officia deserunt mollit anim id est laborum. </p>
                                    <p>Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                        irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                                </div>
                            </div>

                            <!-- Blockquote -->
                            <div class="blockquote">
                                Want to be healthy and have a perfect body? BigBear is the right decision for you! It
                                will create your personal training program and balance your diet so you could get the
                                shape of your dream shortly!
                            </div>

                            <!--Video Box-->
                            <div class="video-box" style="background-image:url(https://via.placeholder.com/1170x594)">
                                <figure class="video-image">
                                    <img src="https://via.placeholder.com/849x498" alt="">
                                </figure>
                                <a href="https://www.youtube.com/watch?v=kxPCFljwJws"
                                   class="lightbox-image overlay-box"><span class="flaticon-play-arrow"><i
                                            class="ripple"></i></span></a>
                            </div>

                            <!-- Post Share Options-->
                            <div class="post-share-options clearfix">
                                <ul class="social-box">
                                    <li class="share">MY SOCIALS:</li>
                                    <li><a href="#"><span class="fa fa-facebook-f"></span></a></li>
                                    <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fa fa-youtube-play"></span></a></li>
                                </ul>
                            </div>

                        </div>

                        <!-- Comment Form -->
                        <div class="comment-form">
                            <div class="group-title"><h3>GET APPOINTMENT</h3></div>
                            <div class="form-text">If you need of a Personal Trainer, Fitness Instructor advice, or a
                                healthy living product review, <br> please feel free to contact us
                            </div>
                            <!--Comment Form-->
                            <form method="post" action="blog.html">
                                <div class="row clearfix">

                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <input type="text" name="username" placeholder=" Test Name" required>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <input type="email" name="email" placeholder="Email" required>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <textarea class="darma" name="message" placeholder="Your Message"></textarea>
                                    </div>

                                    <div class="col-lg-12 clearfix col-md-12 col-sm-12 form-group">
                                        <button class="theme-btn btn-style-one" type="submit" name="submit-form"><span
                                                class="txt">SEND MESSAGE</span></button>
                                        <span class="data">* Personal data will be encrypted </span>
                                    </div>

                                </div>
                            </form>

                        </div>
                        <!-- End Comment Form -->

                    </div>
                </div>

                <!-- Sidebar Side -->
                <div class="sidebar-side col-lg-3 col-md-12 col-sm-12">
                    <aside class="sidebar sticky-top">
                        <div class="sidebar-inner">

                            <!-- Trainer Widget -->
                            <div class="sidebar-widget trainer-widget">
                                <!-- Sidebar Title -->
                                <div class="sidebar-title">
                                    <h5>OTHER TRAINERS</h5>
                                </div>

                                <!-- Trainer Block -->
                                <div class="trainer-block">
                                    <div class="inner-box">
                                        <div class="image">
                                            <img src="https://via.placeholder.com/271x395" alt=""/>
                                            <!-- Overlay Box -->
                                            <div class="overlay-box">
                                                <a href="body-builder-2.html" class="overlay-link"></a>
                                                <div class="overlay-inner">
                                                    <div class="content">
                                                        <h4><a href="body-builder-2.html">JENNIFER</a></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trainer Block -->
                                <div class="trainer-block">
                                    <div class="inner-box">
                                        <div class="image">
                                            <img src="https://via.placeholder.com/271x395" alt=""/>
                                            <!-- Overlay Box -->
                                            <div class="overlay-box">
                                                <a href="body-builder-2.html" class="overlay-link"></a>
                                                <div class="overlay-inner">
                                                    <div class="content">
                                                        <h4><a href="body-builder-2.html">JOHNATHAN</a></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trainer Block -->
                                <div class="trainer-block">
                                    <div class="inner-box">
                                        <div class="image">
                                            <img src="https://via.placeholder.com/271x395" alt=""/>
                                            <!-- Overlay Box -->
                                            <div class="overlay-box">
                                                <a href="body-builder-2.html" class="overlay-link"></a>
                                                <div class="overlay-inner">
                                                    <div class="content">
                                                        <h4><a href="body-builder-2.html">MONICA</a></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </aside>
                </div>

            </div>
        </div>
    </div>

@endsection
