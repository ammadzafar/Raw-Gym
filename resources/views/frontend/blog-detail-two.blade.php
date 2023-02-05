@extends('frontend.layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x974)">
        <div class="auto-container">
            <h2>BLOG POST</h2>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li>How to maximise time spent at the gym</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Sidebar Page Container -->
    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Sidebar Side -->
                <div class="sidebar-side col-lg-3 col-md-12 col-sm-12">
                    <aside class="sidebar sticky-top">
                        <div class="sidebar-inner">

                            <!-- News Widget -->
                            <div class="sidebar-widget news-widget">
                                <!-- Sidebar Title -->
                                <div class="sidebar-title">
                                    <h5>Popular Posts</h5>
                                </div>

                                <div class="widget-content">

                                    <div class="post">
                                        <div class="thumb"><a href="blog-single.html"><img
                                                    src="https://via.placeholder.com/85x85" alt=""></a></div>
                                        <h5><a href="blog-single.html">HOW TO MAXIMISE TIME SPENT AT THE GYM</a></h5>
                                        <span class="date">JUNE 21, 2020</span>
                                    </div>

                                    <div class="post">
                                        <div class="thumb"><a href="blog-single.html"><img
                                                    src="https://via.placeholder.com/85x85" alt=""></a></div>
                                        <h5><a href="blog-single.html">10 TIPS HOW TO PREPARE MEALS FAST AND EASY</a>
                                        </h5>
                                        <span class="date">JUNE 21, 2020</span>
                                    </div>

                                    <div class="post">
                                        <div class="thumb"><a href="blog-single.html"><img
                                                    src="https://via.placeholder.com/85x85" alt=""></a></div>
                                        <h5><a href="blog-single.html">SIMPLE CONDITION FOR ALL AROUND FITNESS</a></h5>
                                        <span class="date">JUNE 21, 2020</span>
                                    </div>

                                </div>

                            </div>

                            <!-- Category Widget -->
                            <div class="sidebar-widget category-widget">
                                <!-- Sidebar Title -->
                                <div class="sidebar-title">
                                    <h5>CATEGORIES</h5>
                                </div>

                                <div class="widget-content">
                                    <ul class="blog-cat">
                                        <li><a href="#">FITNESS (7)</a></li>
                                        <li><a href="#">HEALTH (15)</a></li>
                                        <li><a href="#">LIFESTYLE (29)</a></li>
                                        <li><a href="#">TRAINING PROGRAM (3)</a></li>
                                        <li><a href="#">SPORT SCIENCE (5)</a></li>
                                        <li><a href="#">NUTRITION (4)</a></li>
                                    </ul>
                                </div>

                            </div>

                            <!-- Instagram Widget -->
                            <div class="sidebar-widget instagram-widget">
                                <!-- Sidebar Title -->
                                <div class="sidebar-title">
                                    <h5>INSTAGRAM</h5>
                                </div>
                                <div class="images-outer clearfix">
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                    <!--Image Box-->
                                    <figure class="image-box"><a href="https://via.placeholder.com/320x320"
                                                                 class="lightbox-image" data-fancybox="footer-gallery"
                                                                 title="Image Title Here"
                                                                 data-fancybox-group="footer-gallery"><img
                                                src="https://via.placeholder.com/80x80" alt=""></a></figure>
                                </div>
                            </div>

                            <!-- Newsletter Widget -->
                            <div class="sidebar-widget newsletter-widget">
                                <!-- Sidebar Title -->
                                <div class="sidebar-title">
                                    <h5>NEWSLETTER</h5>
                                </div>
                                <div class="text">BIGBEAR – fitness health center where your body gets its shape! Start
                                    training now to stay fit and healthy all year round!
                                </div>
                                <!-- Newsletter Form -->
                                <div class="newsletter-form">
                                    <form method="post" action="contact.html">
                                        <div class="form-group">
                                            <input type="email" name="email" value="" placeholder="Email" required="">
                                            <button type="submit" class="theme-btn submit-btn"><span
                                                    class="txt fa fa-envelope-o"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </aside>
                </div>

                <!-- Content Side -->
                <div class="content-side col-lg-9 col-md-12 col-sm-12">
                    <div class="blog-detail style-two">
                        <div class="inner-box">
                            <h5>HOW TO MAXIMISE TIME SPENT AT THE GYM</h5>
                            <div class="image">
                                <img src="https://via.placeholder.com/848x589" alt=""/>
                            </div>
                            <ul class="post-info">
                                <li><span>By: </span>Adam John</li>
                                <li><span>Date: </span>September 27, 2020</li>
                                <li><span>Category: </span>Health</li>
                            </ul>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit
                                voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                                inventore veritatis et quasi architecto beatae vitae dicta sunt.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit
                                voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                                inventore veritatis et quasi architecto beatae vitae dicta sunt.</p>
                            <!-- Blockquote -->
                            <div class="blockquote">
                                Want to be healthy and have a perfect body? BigBear is the right decision for you! It
                                will create your personal training program and balance your diet so you could get the
                                shape of your dream shortly!
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                TExcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit
                                voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                                inventore veritatis et quasi architecto beatae vitae dicta sunt</p>

                            <!--Video Box-->
                            <div class="video-box" style="background-image:url(https://via.placeholder.com/1170x594)">
                                <figure class="video-image">
                                    <img src="https://via.placeholder.com/1170x594" alt="">
                                </figure>
                                <a href="https://www.youtube.com/watch?v=kxPCFljwJws"
                                   class="lightbox-image overlay-box"><span class="flaticon-play-arrow"><i
                                            class="ripple"></i></span></a>
                            </div>

                            <!-- Post Share Options-->
                            <div class="post-share-options clearfix">
                                <div class="pull-left">
                                    <ul class="social-box">
                                        <li class="share">MY SOCIALS:</li>
                                        <li><a href="#"><span class="fa fa-facebook-f"></span></a></li>
                                        <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                        <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                                        <li><a href="#"><span class="fa fa-youtube-play"></span></a></li>
                                    </ul>
                                </div>
                                <div class="pull-right">
                                    <ul class="posts">
                                        <li><a href="#"><span class="arrow flaticon-back-1"></span>&ensp; Prev</a></li>
                                        <li><a href="#">Next &ensp; <span
                                                    class="arrow flaticon-arrow-pointing-to-right"></span></a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Related Posts -->
                    <div class="related-posts style-two">
                        <h5>Articles Also Like</h5>
                        <div class="row clearfix">

                            <!-- News Block -->
                            <div class="news-block style-two col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a class="overlay-link" href="blog-detail.html"></a>
                                        <img src="https://via.placeholder.com/416x255" alt=""/>
                                        <div class="post-date">
                                            <span>7</span>SEP
                                        </div>
                                        <div class="content">
                                            <h4><a href="blog-detail.html">SIMPLE CONDITION FOR ALL AROUND FITNESS</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- News Block -->
                            <div class="news-block style-two col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <a class="overlay-link" href="blog-detail.html"></a>
                                    <div class="image">
                                        <img src="https://via.placeholder.com/416x255" alt=""/>
                                        <div class="post-date">
                                            <span>18</span>SEP
                                        </div>
                                        <div class="content">
                                            <h4><a href="blog-detail.html">10 TIPS HOW TO PREPARE MEALS FAST AND
                                                    EASY</a></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
