<!-- Pricing Section -->
<section class="pricing-section" id="pricing_section" style="background-image: url('{{ asset('frontend/assets/images/galleryy/1-bg.jpg') }}')">
    <div class="auto-container">
        <div class="sec-title centered">
            <h2><span>Program</span> Pricing</h2>
        </div>
        <div class="row clearfix">
             @php
             $memberships = \App\Models\Membership::whereFeatured(1)->limit(3)->get();

             @endphp
            <!-- Pricing Block -->
            @foreach($memberships as $membership)
            <div class="price-block col-lg-4 col-md-4 col-sm-12">
                <div class="side-text">{{$membership->name}}</div>
                <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="icon-box">
                            <span class="icon"><img src="{{ asset('frontend/assets/images/icons/price-1-icon.svg') }}"
                                                    alt=""/></span>
                    </div>
                    <ul class="price-list">
                        <li >Membership Card</li>
                        <li>{{$membership->description}}</li>
                        <li>Diet Plan Included</li>
                        <li class="hide">Registeration Fee {{$membership->reg_fee}}</li>
                    </ul>
                    <div class="price">RS {{$membership->fees}}<span>For {{$membership->duration}} Month</span></div>
                    <div class="theme-btn btn-style-one purchase-box-btn"><span class="txt">For Consultation</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
<!-- End Pricing Section -->
