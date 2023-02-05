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

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="auto-container">

            <!--Cart Outer-->
            <div class="cart-outer">
                <div class="table-outer">
                    <table class="cart-table">
                        <thead class="cart-header">
                        <tr>
                            <th class="prod-column">Product</th>
                            <th class="price">Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td class="prod-column">
                                <div class="column-box">
                                    <figure class="prod-thumb"><a href="#"><img src="https://via.placeholder.com/93x112"
                                                                                alt=""></a></figure>
                                    <h6 class="prod-title">Running Lassina</h6>
                                </div>
                            </td>
                            <td class="price">$96.90</td>
                            <td class="qty"><input class="quantity-spinner" type="text" value="2" name="quantity"></td>
                            <td class="sub-total">$96.90</td>
                            <td class="remove"><a href="#" class="remove-btn"><span
                                        class="flaticon-multiply"></span></a></td>
                        </tr>

                        <tr>
                            <td class="prod-column">
                                <div class="column-box">
                                    <figure class="prod-thumb"><a href="#"><img src="https://via.placeholder.com/93x112"
                                                                                alt=""></a></figure>
                                    <h6 class="prod-title">Running Lassina</h6>
                                </div>
                            </td>
                            <td class="price">$96.90</td>
                            <td class="qty"><input class="quantity-spinner" type="text" value="2" name="quantity"></td>
                            <td class="sub-total">$96.90</td>
                            <td class="remove"><a href="#" class="remove-btn"><span
                                        class="flaticon-multiply"></span></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="coupon-outer clearfix">
                    <div class="pull-left">
                        <div class="apply-coupon clearfix">
                            <div class="form-group clearfix">
                                <input type="text" name="coupon-code" value="" placeholder="Coupon Code">
                            </div>
                            <div class="form-group clearfix">
                                <button type="button" class="theme-btn coupon-btn btn-style-one"><span class="txt">Apply Coupon</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pull-right">
                        <button type="button" class="theme-btn btn-style-one cart-btn"><span
                                class="txt">Update Cart</span></button>
                    </div>

                </div>

                <!--Cart Total Box-->
                <div class="cart-total-box">
                    <h4>Cart Totals</h4>
                    <!--Totals Table-->
                    <ul class="totals-table">
                        <li class="clearfix"><span class="col col-title">Subtotal</span><span class="col">$96.90</span>
                        </li>
                        <li class="clearfix"><span class="col col-title">Tax</span><span class="col">$96.90</span></li>
                        <li class="total clearfix"><span class="col col-title">Total .</span><span
                                class="col">$193.2</span></li>
                    </ul>
                </div>
                <div class="text-left">
                    <button type="submit" class="theme-btn btn-style-one checkout-btn"><span class="txt">Proceed to Checkout</span>
                    </button>
                </div>
            </div>

        </div>
    </section>

@endsection
