<!-- Main Footer -->
<footer class="main-footer" style="background-image:url({{ asset('frontend/assets/images/galleryy/2--lpkInK.jpg') }})">
    <div class="auto-container">
        <!-- Widgets Section -->
        <div class="widgets-section">
            <div class="row clearfix">

                <!-- Big Column -->

                <!--Footer Column-->
                <div class="footer-column col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget logo-widget">
                        <div class="logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('images/logo-light-lg.png') }}" alt=""/></a>
                        </div>
                        <!-- Footer Mobile Logo -->
                        <div class="footer-mobile-logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('images/logo-light-lg.png') }}" alt=""
                                                          title=""></a>
                        </div>
                        <ul class="info-list">
                            <li><span>Address:</span>Faisal Ghuman Rd, N B Villas, Lahore, Punjab 54800</li>
                            <li><span>Phones:</span>
                                <a href="tel:+923011114567">+92 301 1114567</a><br>
                                {{--                                        <a href="tel:1-123-456-78-80">+1-123-456-78-80</a>--}}
                            </li>
                            <li><span>Working Hours:</span>
                                Gents:5AM To 9AM <br>
                                Ladies:9AM To 4PM <br>
                                Combine:4PM To 11PM
                            </li>
                            <li><span>Email:</span><a href="mailto:support@musclebarfitness.com">support@musclebarfitness.com</a>
                            </li>
                            <li class="social-links"><span>Our Socials:</span>
                                <a href="https://www.facebook.com/MuscleBar2021" target="_blank"
                                   class="fa fa-facebook"></a>
                                {{--                                        <a href="#" class="fa fa-twitter"></a>--}}
                                {{--                                        <a href="#" class="fa fa-instagram"></a>--}}
                                {{--                                        <a href="#" class="fa fa-linkedin"></a>--}}
                            </li>
                        </ul>
                    </div>
                </div>

                <!--Footer Column-->
            {{--<div class="footer-column col-lg-6 col-md-6 col-sm-12">
                <div class="footer-widget news-widget">
                    <h6>BLOG POSTS</h6>
                    <div class="widget-content">

                        <div class="post">
                            <div class="thumb"><a href="blog-single.html"><img
                                        src="{{ asset('frontend/assets/images/galleryy/post-thumb-1.jpg') }}" alt=""></a></div>
                            <h5><a href="blog-single.html">HOW TO MAXIMISE TIME SPENT AT THE GYM</a>
                            </h5>
                            <span class="date">JUNE 21, 2020</span>
                        </div>

                        <div class="post">
                            <div class="thumb"><a href="blog-single.html"><img
                                        src="{{ asset('frontend/assets/images/galleryy/post-thumb-2.jpg') }}" alt=""></a></div>
                            <h5><a href="blog-single.html">10 TIPS HOW TO PREPARE MEALS FAST AND
                                    EASY</a></h5>
                            <span class="date">JUNE 21, 2020</span>
                        </div>

                        <div class="post">
                            <div class="thumb"><a href="blog-single.html"><img
                                        src="{{ asset('frontend/assets/images/galleryy/post-thumb-3.jpg') }}" alt=""></a></div>
                            <h5><a href="blog-single.html">SIMPLE CONDITION FOR ALL AROUND FITNESS</a>
                            </h5>
                            <span class="date">JUNE 21, 2020</span>
                        </div>

                    </div>
                </div>
            </div>--}}


            <!-- Big Column -->

                <!-- Footer Column -->
                <div class="footer-column col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget gallery-widget">
                        <h6>Instagram</h6>
                        <div class="widget-content">

                            <div class="images-outer clearfix">
                                <!--Image Box-->

                                @forelse($instagramImages as $key=>$image)

                                    <figure class="image-box"><a
                                            href="{{ asset('storage/' . $image) }}"
                                            class="lightbox-image"
                                            data-fancybox="footer-gallery"
                                            title="Image Title Here"
                                            data-fancybox-group="footer-gallery"><img
                                                src="{{ asset('storage/' . $image) }}"
                                                alt=""></a></figure>


{{--                                    <img src="{{ asset($image) }}" alt="" class="img-responsive">--}}
                                @empty
                                    <span>No image found!</span>
                            @endforelse
                            <!--Image Box-->

                            </div>

                        </div>
                    </div>
                </div>

                <!--Footer Column-->
                <div class="footer-column col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget newsletter-widget">
                        <h6>Newsletter</h6>
                        <div class="text">BLACKFIT – fitness health center where your body gets its shape!
                            Start training now to stay fit and healthy all year round!
                        </div>
                        <!-- Newsletter Form -->
                        <div class="newsletter-form">
                            <form id="newsletter">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" value="" placeholder="Email"
                                           required="" id="email">
                                    <button type="submit" class="theme-btn submit-btn"><span><img
                                                src="{{ asset('frontend/assets/images/icons/message-icon.png') }}"
                                                alt=""/></span></button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>


            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="copyright">©
                <script>


                    /* $('#newsletter').on("submit", function (e) {
                         e.preventDefault();
                         alert('kahn');

                     });*/

                </script>
                RAW Gym. Crafted by <a href="#">CodeX Technologies</a></div>
        </div>

    </div>
</footer>
