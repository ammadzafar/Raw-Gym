<div id="purchase-popup" class="purchase-popup">
    <div class="close-search theme-btn"><span>Close</span></div>
    <div class="popup-inner">
        <div class="overlay-layer"></div>

        <div class="purchase-form">
            <div class="sec-title centered">
                <h2><span>GET FREE</span> CONSULTATION</h2>
                <div class="text">If you need of a Personal Trainer, Fitness Instructor advice, or a healthy <br> living
                    product review, please feel free to contact us
                </div>
            </div>

            <!-- Default Form -->
            <form id="consultation">
                @csrf
                <div class="row clearfix">

                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                        <input type="text" name="name" placeholder="Name" required>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <input type="tel" name="mobile" placeholder="Mobile Nubmer" required>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <input type="text" name="subject" placeholder="Subject" required>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <textarea class="darma" name="message" placeholder="Your Message"></textarea>
                    </div>

                    <div class="form-group text-center col-lg-12 col-md-12 col-sm-12">
                        <span class="data">* Personal data will be encrypted </span>
                        <button class="theme-btn btn-style-one" type="submit" name="submit-form"><span class="txt">SEND MESSAGE</span>
                        </button>
                    </div>

                </div>
            </form>


        </div>

    </div>
</div>
