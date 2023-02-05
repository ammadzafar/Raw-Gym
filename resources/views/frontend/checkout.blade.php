@extends('frontend.layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x720)">
        <div class="auto-container">
            <h2>CART</h2>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Checkout Page -->
    <div class="checkout-page">
        <div class="auto-container">

            <!--Billing Details-->
            <div class="billing-details">
                <div class="shop-form">
                    <form method="post" action="checkout.html">
                        <div class="row clearfix">
                            <div class="col-lg-7 col-md-12 col-sm-12">

                                <div class="sec-title"><h2>Billing Details</h2></div>
                                <div class="billing-inner">
                                    <div class="row clearfix">

                                        <!--Form Group-->
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">First name <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Last name <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Company name (optional)</div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Country <sup>*</sup></div>
                                            <select name="country">
                                                <option>Select an option</option>
                                                <option>Pakistan</option>
                                                <option>USA</option>
                                                <option>CANADA</option>
                                                <option>INDIA</option>
                                            </select>
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Street address <sup>*</sup></div>
                                            <input type="text" name="field-name" value=""
                                                   placeholder="House number and streen name">
                                            <input class="address-two" type="text" name="field-name" value=""
                                                   placeholder="Apartment, suite, unite etc (optional)">
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Town / City <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">State / Country <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>


                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Postcode / ZIP <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Phone <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>

                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Email adress <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>

                                    </div>

                                    <!-- Checkout Order Box -->
                                    <div class="checkout-order-box">
                                        <h3>Your Order</h3>
                                        <div class="upper-box">
                                            <ul>
                                                <li>Run Shoes <i>X 1</i> <span>$98.00</span></li>
                                                <li>Run Wear <i>X 1</i> <span>$22.00</span></li>
                                            </ul>
                                        </div>
                                        <div class="lower-box">
                                            <ul>
                                                <li>Subtotal <span>$120.00</span></li>
                                                <li><strong>Total</strong> <span><strong>$120.00</strong></span></li>
                                            </ul>
                                        </div>
                                        <div class="text">Your personal data will be used to process your order, support
                                            your experience throughout this website, and for other purposes described in
                                            our privacy policy.
                                        </div>
                                        <button type="button" class="theme-btn btn-style-one"><span class="txt">Place Order</span>
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-5 col-md-12 col-sm-12">
                                <div class="sec-title"><h2>Additional information</h2></div>

                                <div class="row clearfix">

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Order notes (optional)</div>
                                        <textarea placeholder=""></textarea>
                                    </div>

                                    <div class="coupon-box form-group col-md-12 col-sm-12 col-xs-12">
                                        <h3>Have a coupon?</h3>

                                        <!-- Coupon Form-->
                                        <div class="coupon-form">
                                            <form method="post" action="contact.html">
                                                <div class="form-group">
                                                    <input type="email" name="email" value="" placeholder="Coupon code"
                                                           required>
                                                    <button type="button" class="theme-btn btn-style-one"><span
                                                            class="txt">APPLY COUPON</span></button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </form>

                </div>

            </div><!--End Billing Details-->
        </div>
    </div>

@endsection
