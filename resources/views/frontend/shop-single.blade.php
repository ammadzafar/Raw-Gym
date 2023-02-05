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

    <!-- Shop Single Section -->
    <section class="shop-single-section">
        <div class="auto-container">

            <!--Shop Single-->
            <div class="shop-page product-details">

                <!--Basic Details-->
                <div class="basic-details">
                    <div class="row clearfix">

                        <div class="image-column col-lg-6 col-md-12 col-sm-12">
                            <div class="carousel-outer">

                                <ul class="image-carousel owl-carousel owl-theme">
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                    <li><a href="https://via.placeholder.com/570x676" class="lightbox-image"
                                           title="Image Caption Here"><img src="https://via.placeholder.com/570x676"
                                                                           alt=""></a></li>
                                </ul>

                                <ul class="thumbs-carousel owl-carousel owl-theme">
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                    <li><img src="https://via.placeholder.com/171x176" alt=""></li>
                                </ul>

                            </div>
                        </div>

                        <!--Info Column-->
                        <div class="info-column col-lg-6 col-md-12 col-sm-12">
                            <div class="details-header">
                                <h5>Running Brand Snikers</h5>
                                <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse
                                    ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.
                                </div>
                                <div class="item-price">$96.90</div>
                            </div>

                            <div class="other-options">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <div class="item-quantity"><input class="quantity-spinner" type="text" value="2"
                                                                          name="quantity"></div>
                                    </div>
                                    <div class="pull-left">
                                        <!--Btns Box-->
                                        <div class="btns-box">
                                            <a href="checkout.html" class="theme-btn btn-style-one"><span class="txt">ADD TO CARD &ensp;<i
                                                        class="flaticon-shopping-cart-3"></i></span></a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <ul class="shop-list">
                                <li><strong>SKU:</strong>N/A</li>
                                <li><strong>Categories:</strong>New Arrivals</li>
                                <li><strong>Tag:</strong>Sport</li>
                            </ul>

                        </div>

                    </div>
                </div>
                <!-- Basic Details -->
            </div>

            <!-- Related Products -->
            <div class="related-products">
                <h5>RELATED PRODUCTS</h5>
                <div class="row clearfix">

                    <!-- Shop Item -->
                    <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <div class="image">
                                <a class="overlay-link" href="shop-single.html"></a>
                                <img src="https://via.placeholder.com/370x500" alt=""/>
                                <div class="overlay-box">
                                    <ul class="cart-option">
                                        <li><a href="shop-single.html"><span><img src="images/icons/right-arrow.svg"
                                                                                  alt=""/></span></a></li>
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
                    <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <div class="image">
                                <a class="overlay-link" href="shop-single.html"></a>
                                <img src="https://via.placeholder.com/370x500" alt=""/>
                                <div class="overlay-box">
                                    <ul class="cart-option">
                                        <li><a href="shop-single.html"><span><img src="images/icons/right-arrow.svg"
                                                                                  alt=""/></span></a></li>
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
                    <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <div class="image">
                                <a class="overlay-link" href="shop-single.html"></a>
                                <img src="https://via.placeholder.com/370x500" alt=""/>
                                <div class="overlay-box">
                                    <ul class="cart-option">
                                        <li><a href="shop-single.html"><span><img src="images/icons/right-arrow.svg"
                                                                                  alt=""/></span></a></li>
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
            </div>

        </div>
    </section>
    <!-- End Shop Single Section -->

@endsection
