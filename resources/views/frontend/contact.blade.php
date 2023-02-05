@extends('frontend.layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x960)">
        <div class="auto-container">
            <h2>CONTACTS</h2>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Contact Page Section -->
    <section class="contact-page-section">
        <div class="auto-container">

            <!-- Map Boxed -->
            <div class="map-boxed">
                <!--Map Outer-->
                <div class="map-outer">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d805184.6331292129!2d144.49266890254142!3d-37.97123689954809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad646b5d2ba4df7%3A0x4045675218ccd90!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2s!4v1574408946759!5m2!1sen!2s"
                        width="100%" height="460px" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                </div>
            </div>

            <div class="row clearfix">

                <!-- Info Column -->
                <div class="info-column col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <ul class="info-list">
                            <li><span>Address:</span>4578 Marmora Road, Glasgow</li>
                            <li><span>Phones:</span>
                                <a href="tel:1-123-456-78-89">+1-123-456-78-89</a><br>
                                <a href="tel:1-123-456-78-80">+1-123-456-78-80</a>
                            </li>
                            <li><span>Working Hours:</span>Monday-Sunday: 07:00 - 22:00</li>
                            <li><span>Email:</span><a href="mailto:info@bigbear.com">info@bigbear.com</a></li>
                            <li class="social-links"><span>Our Socials:</span>
                                <a href="#" class="fa fa-facebook"></a>
                                <a href="#" class="fa fa-twitter"></a>
                                <a href="#" class="fa fa-instagram"></a>
                                <a href="#" class="fa fa-linkedin"></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="form-column col-lg-8 col-md-12 col-sm-12">
                    <div class="inner-column">

                        <!-- Contact Form -->
                        <div class="contact-form">
                            <div class="group-title"><h3>GET APPOINTMENT</h3></div>
                            <div class="form-text">If you need of a Personal Trainer, Fitness Instructor advice, or a
                                healthy living product review, please feel free to contact us
                            </div>
                            <!-- Contact Form -->
                            <form method="post" action="sendemail.php" id="contact-form">
                                <div class="row clearfix">

                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <input type="text" name="username" placeholder="Name" required>
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
                                        <span class="data">* Personal data will be encrypted ?</span>
                                    </div>

                                </div>
                            </form>

                        </div>
                        <!-- End Contact Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- End Contact Page Section -->

@endsection
