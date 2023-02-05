@extends('frontend.layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x720)">
        <div class="auto-container">
            <h2>OUR STORE</h2>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Shop</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Sidebar Page Container -->
    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Sidebar Side -->
                <div class="sidebar-side shop-sidebar col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar sticky-top">
                        <div class="sidebar-inner padding-right">

                            <div class="row clearfix">

                                <!-- Category Widget -->
                                <div class="sidebar-widget category-widget col-lg-12 col-md-6 col-sm-12">
                                    <!-- Sidebar Title -->
                                    <div class="sidebar-title">
                                        <h5>CATEGORIES</h5>
                                    </div>

                                    <div class="widget-content">
                                        <ul class="shop-cat">
                                            <li><a href="#">All Products <span>26</span></a></li>
                                            <li><a href="#">Arrivals <span>6</span></a></li>
                                            <li><a href="#">Fashion <span>10</span></a></li>
                                            <li><a href="#">Nutrition <span>8</span></a></li>
                                            <li><a href="#">Lifestyle <span>7</span></a></li>
                                        </ul>
                                    </div>

                                </div>

                                <!-- Price Filters -->
                                <div
                                    class="sidebar-widget price-filters rangeslider-widget col-lg-12 col-md-6 col-sm-12">
                                    <!-- Sidebar Title -->
                                    <div class="sidebar-title">
                                        <h5>FILTER BY PRICE</h5>
                                    </div>
                                    <div class="range-slider-one clearfix">
                                        <div class="price-range-slider"></div>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <a href="#" class="theme-btn btn-style-one"><span
                                                        class="txt">Filtter</span></a>
                                            </div>
                                            <div class="pull-right">
                                                <div class="title">Price:</div>
                                                <div class="input"><input type="text" class="property-amount"
                                                                          name="field-name" readonly></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Related Posts -->
                                <div class="sidebar-widget related-posts col-lg-12 col-md-12 col-sm-12">
                                    <!-- Sidebar Title -->
                                    <div class="sidebar-title">
                                        <h5>NEW ARRIVALS</h5>
                                    </div>
                                    <div class="widget-content">

                                        <div class="post">
                                            <figure class="post-thumb"><a href="shop-single.html"><img
                                                        src="https://via.placeholder.com/130x155" alt=""></a></figure>
                                            <h4><a href="shop-single.html">Running <br> Shoes</a></h4>
                                            <div class="price">$96.90</div>
                                        </div>

                                        <div class="post">
                                            <figure class="post-thumb"><a href="shop-single.html"><img
                                                        src="https://via.placeholder.com/130x155" alt=""></a></figure>
                                            <h4><a href="shop-single.html">Running <br> Shoes</a></h4>
                                            <div class="price">$96.90</div>
                                        </div>

                                        <div class="post">
                                            <figure class="post-thumb"><a href="shop-single.html"><img
                                                        src="https://via.placeholder.com/130x155" alt=""></a></figure>
                                            <h4><a href="shop-single.html">Running <br> Shoes</a></h4>
                                            <div class="price">$96.90</div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </aside>
                </div>

                <!-- Content Side -->
                <div class="content-side shop-products col-lg-8 col-md-12 col-sm-12">
                    <!-- Shop Single -->
                    <div class="shop-section">

                        <!-- Sort By -->
                        <div class="items-sorting">
                            <div class="total-items">Showing <span>1-6 of 26</span></div>
                        </div>

                        <div class="row clearfix">

                            <!-- Shop Item -->
                            <div class="shop-item col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a class="overlay-link" href="shop-single.html"></a>
                                        <img src="https://via.placeholder.com/370x500" alt=""/>
                                        <div class="overlay-box">
                                            <ul class="cart-option">
                                                <li><a href="shop-single.html"><span><img
                                                                src="images/icons/right-arrow.svg" alt=""/></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="shop-single.html">Running Brand Snikers</a></h3>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="price">$96.90</div>
                                            </div>
                                            <div class="pull-right">
                                                <!-- Rating -->
                                                <a href="shop-single.html" class="cart"><span
                                                        class="icon flaticon-shopping-cart-3"></span></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Shop Item -->
                            <div class="shop-item col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a class="overlay-link" href="shop-single.html"></a>
                                        <div class="sale">sale</div>
                                        <img src="https://via.placeholder.com/370x500" alt=""/>
                                        <div class="overlay-box">
                                            <ul class="cart-option">
                                                <li><a href="shop-single.html"><span><img
                                                                src="images/icons/right-arrow.svg" alt=""/></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="shop-single.html">Nutrition Milada</a></h3>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="price">$3.90</div>
                                            </div>
                                            <div class="pull-right">
                                                <!-- Rating -->
                                                <a href="shop-single.html" class="cart"><span
                                                        class="icon flaticon-shopping-cart-3"></span></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Shop Item -->
                            <div class="shop-item col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a class="overlay-link" href="shop-single.html"></a>
                                        <img src="https://via.placeholder.com/370x500" alt=""/>
                                        <div class="overlay-box">
                                            <ul class="cart-option">
                                                <li><a href="shop-single.html"><span><img
                                                                src="images/icons/right-arrow.svg" alt=""/></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="shop-single.html">Running Sniker</a></h3>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="price">$83.90</div>
                                            </div>
                                            <div class="pull-right">
                                                <!-- Rating -->
                                                <a href="shop-single.html" class="cart"><span
                                                        class="icon flaticon-shopping-cart-3"></span></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Shop Item -->
                            <div class="shop-item col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a class="overlay-link" href="shop-single.html"></a>
                                        <img src="https://via.placeholder.com/370x500" alt=""/>
                                        <div class="overlay-box">
                                            <ul class="cart-option">
                                                <li><a href="shop-single.html"><span><img
                                                                src="images/icons/right-arrow.svg" alt=""/></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="shop-single.html">Running Wear</a></h3>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="price">$63.90</div>
                                            </div>
                                            <div class="pull-right">
                                                <!-- Rating -->
                                                <a href="shop-single.html" class="cart"><span
                                                        class="icon flaticon-shopping-cart-3"></span></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Shop Item -->
                            <div class="shop-item col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a class="overlay-link" href="shop-single.html"></a>
                                        <img src="https://via.placeholder.com/370x500" alt=""/>
                                        <div class="overlay-box">
                                            <ul class="cart-option">
                                                <li><a href="shop-single.html"><span><img
                                                                src="images/icons/right-arrow.svg" alt=""/></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="shop-single.html">Running Sniker</a></h3>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="price">$83.90</div>
                                            </div>
                                            <div class="pull-right">
                                                <!-- Rating -->
                                                <a href="shop-single.html" class="cart"><span
                                                        class="icon flaticon-shopping-cart-3"></span></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Shop Item -->
                            <div class="shop-item col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a class="overlay-link" href="shop-single.html"></a>
                                        <img src="https://via.placeholder.com/370x500" alt=""/>
                                        <div class="overlay-box">
                                            <ul class="cart-option">
                                                <li><a href="shop-single.html"><span><img
                                                                src="images/icons/right-arrow.svg" alt=""/></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="shop-single.html">Nutrition Banana</a></h3>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="price">$3.90</div>
                                            </div>
                                            <div class="pull-right">
                                                <!-- Rating -->
                                                <a href="shop-single.html" class="cart"><span
                                                        class="icon flaticon-shopping-cart-3"></span></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Lower Text -->
                        <div class="lower-text text-center">
                            <a href="#" class="products">MORE PRODUCTS</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
