@extends('frontend.layouts.master')

@section('page-title', 'Homepage')

@section('content')
    <!-- Banner Section -->
    <section class="banner-section">
        <div class="main-slider-carousel owl-carousel owl-theme">

            <div class="slide">
                <div class="image-layer"
                     style="background-image:url('{{ asset('frontend/assets/images/galleryy/image-1.jpg') }}')"></div>
                <div class="auto-container">
                    <!-- Content Boxed -->
                    <div class="content-boxed">
                        <div class="inner-boxed">
                            <h1>KEEP YOUR BODY <span>FIT & STRONG</span></h1>
                            <div class="text">BLACKFIT – fitness health center where your body gets its shape! <br>
                                Start training now to stay fit and healthy all year round!
                            </div>
                            <div class="btns-box">
                                <div class="theme-btn purchase-box-btn btn-style-one"><span
                                        class="txt">LET’S TRAIN</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="slide">
                <div class="image-layer"
                     style="background-image:url('{{ asset('frontend/assets/images/galleryy/image-2.jpg') }}')"></div>
                <div class="auto-container">
                    <!-- Content Boxed -->
                    <div class="content-boxed">
                        <div class="inner-boxed">
                            <h1>KEEP YOUR BODY <span>FIT & STRONG</span></h1>
                            <div class="text">BLACKFIT – fitness health center where your body gets its shape! <br>
                                Start training now to stay fit and healthy all year round!
                            </div>
                            <div class="btns-box">
                                <div class="theme-btn purchase-box-btn btn-style-one"><span
                                        class="txt">LET’S TRAIN</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="slide">
                <div class="image-layer"
                     style="background-image:url('{{ asset('frontend/assets/images/galleryy/image-3.jpg') }}')"></div>
                <div class="auto-container">
                    <!-- Content Boxed -->
                    <div class="content-boxed">
                        <div class="inner-boxed">
                            <h1>KEEP YOUR BODY <span>FIT & STRONG</span></h1>
                            <div class="text">BLACKFIT – fitness health center where your body gets its shape! <br>
                                Start training now to stay fit and healthy all year round!
                            </div>
                            <div class="btns-box">
                                <div class="theme-btn purchase-box-btn btn-style-one"><span
                                        class="txt">LET’S TRAIN</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="slide">
                <div class="image-layer"
                     style="background-image:url('{{ asset('frontend/assets/images/galleryy/image-4.jpg') }}')"></div>
                <div class="auto-container">
                    <!-- Content Boxed -->
                    <div class="content-boxed">
                        <div class="inner-boxed">
                            <h1>KEEP YOUR BODY <span>FIT & STRONG</span></h1>
                            <div class="text">BLACKFIT – fitness health center where your body gets its shape! <br>
                                Start training now to stay fit and healthy all year round!
                            </div>
                            <div class="btns-box">
                                <div class="theme-btn purchase-box-btn btn-style-one"><span
                                        class="txt">LET’S TRAIN</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!--Scroll Dwwn Btn-->
        <div class="mouse-btn-down scroll-to-target" data-target=".testimonial-section">
            <span class="icon"><img src="{{ asset('frontend/assets/images/icons/scroll.png') }}" alt=""/></span>
        </div>

    </section>
    <!-- End Banner Section -->

    <!-- Services Section -->
    <section id="services_section" class="services-section">
        <div class="outer-container">
            <div class="clearfix">

                <!-- Service Block -->
                <div class="service-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="body-builder.html" class="overlay-link"></a>
                            <img src="{{ asset('frontend/assets/images/galleryy/service-1.jpg') }}" alt=""/>
                            <!-- Overlay Box -->
                            <div class="overlay-box">
                                <div class="overlay-inner">
                                    <div class="content">
                                        <h4><a href="body-builder.html">FITNESS</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Block -->
                <div class="service-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="body-builder.html" class="overlay-link"></a>
                            <img src="{{ asset('frontend/assets/images/galleryy/service-2.jpg') }}" alt=""/>
                            <!-- Overlay Box -->
                            <div class="overlay-box">
                                <div class="overlay-inner">
                                    <div class="content">
                                        <h4><a href="body-builder.html">BODYBUILDING</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Block -->
                <div class="service-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="body-builder.html" class="overlay-link"></a>
                            <img src="{{ asset('frontend/assets/images/galleryy/service-3.jpg') }}" alt=""/>
                            <!-- Overlay Box -->
                            <div class="overlay-box">
                                <div class="overlay-inner">
                                    <div class="content">
                                        <h4><a href="body-builder.html">CROSSFIT</a></h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Service Block -->
                <div class="service-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="body-builder.html" class="overlay-link"></a>
                            <img src="{{ asset('frontend/assets/images/galleryy/service-4.jpg') }}" alt=""/>
                            <!-- Overlay Box -->
                            <div class="overlay-box">
                                <div class="overlay-inner">
                                    <div class="content">
                                        <h4><a href="body-builder.html">CARDIO</a></h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Services Section -->

    <!-- We Are Section -->
    <section id="aboutus_section" class="we-are-section">
        <div class="auto-container">
            <div class="sec-title centered">
                <h2><span>WHO</span> We Are</h2>
                <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br>
                    incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. <br> Risus
                    commodo viverra maecenas accumsan lacus vel facilisis
                </div>
            </div>

            <!--Video Box-->
            <div class="video-box">
                <figure class="video-image">
                    <img src="{{ asset('frontend/assets/images/galleryy/video-img.jpg') }}" alt="">
                </figure>
                <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image overlay-box"><span><img
                            src="{{ asset('frontend/assets/images/icons/play-icon.png') }}" alt=""/><i
                            class="ripple"></i></span></a>
            </div>

            <!-- Button Box -->
            <div class="button-box text-center">
                <div class="heme-btn btn-style-one purchase-box-btn"><span class="txt">FREE CONSULTATION</span></div>
            </div>

        </div>
    </section>
    <!-- End We Are Section -->

    @include('frontend.layouts.gallery')

    @include('frontend.layouts.counter')

    @include('frontend.layouts.pricing')

    @include('frontend.layouts.coaches')

    @include('frontend.layouts.calculator')

    @include('frontend.layouts.testimonials')

    @include('frontend.layouts.testimonials-2')

    @include('frontend.layouts.news')

@endsection

@section('frontend-scripts')
    <script>
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).on("submit", '#newsletter', function (e) {
            e.preventDefault();
            $("#newsletter").validate();
            var formData = new FormData(this);
            $.ajax({
                url: "{{route('newsletter')}}",
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    $('#newsletter').trigger('reset');
                    toastr.success(response.message);
                },
                error: function (error) {
                    $('#newsletter').trigger('reset');
                    toastrErrors(error);
                }
            });

        });

        $('#consultation').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax(
                {
                    url: '{{route('consultation')}}',
                    type: 'post',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#consultation').trigger('reset');
                        $('#purchase-popup').hide();


                    },
                    error: function (error) {
                        // $('#consultation').trigger('reset');
                        toastrErrors(error);
                    }

                }
            )


        });
$('#result').hide();
$(document).on('submit','#bmi',function (e) {
    e.preventDefault();
    var feets = $('#feets').val();
    var inches = $('#inches').val();
    var mass = $('#mass').val();
    var height = (feets*0.3048 +inches*0.0254)**2;
    var bmi =mass/height ;
    $('#result').show();
    $('#result').html("<h3 style='color: white;text-align: center'>"+bmi.toFixed(2)+"</h3>");
    $('#reset').on('click',function () {
        $('#result').hide();

    });

});

    </script>

@endsection
