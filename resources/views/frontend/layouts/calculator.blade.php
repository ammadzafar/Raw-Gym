<!-- Calculator Section -->
<section class="calculator-section">
    <div class="auto-container">
        <div class="sec-title centered">
            <h2><span>bmi</span> CALCULATOR</h2>
            <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <br> tempor
                incididunt ut labore et dolore magna aliqua
            </div>
        </div>

        <div class="inner-container">

            <!-- Default Form -->
            <div class="default-form">

                <!-- Default Form -->
                <form id="bmi">
                    <div class="row clearfix">

                        <div class="col-lg-2 col-md-6 col-sm-12 form-group">
                            <input type="text" name="feets" placeholder="Feet" id="feets" required>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12 form-group">
                            <input type="text" name="inches" placeholder="Innches" id="inches" required>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <input type="text" name="weight" placeholder="Weight / kg" required id="mass">
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <input type="text" name="age" placeholder="Age" required>
                        </div>

                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <select class="custom-select-box">
                                <option>Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <button class="theme-btn btn-style-one" type="submit" name="submit-form"><span
                                    class="txt">CALCULATE</span></button>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <button class="theme-btn btn-style-one" type="reset" name="submit-form" id="reset"><span
                                    class="txt">Reset</span></button>
                        </div>

                        <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                            <p id="result"></p>
                        </div>


                    </div>
                </form>

                <!--End Default Form -->
            </div>

        </div>

    </div>
</section>
<!-- End Calculator Section -->
