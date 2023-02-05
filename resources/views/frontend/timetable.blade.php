@extends('frontend.layouts.master')

@section('content')

	<!--Page Title-->
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x960)">
    	<div class="auto-container">
			<h2>TIME TABLE</h2>
			<ul class="page-breadcrumb">
				<li><a href="index.html">home</a></li>
				<li>Time Table</li>
			</ul>
        </div>
    </section>
    <!--End Page Title-->

	<!-- Timing Section -->
	<section class="timing-section">
		<div class="auto-container">

			<!-- Timing Info Tabs -->
            <div class="timing-info-tabs">
                <!-- Timing Tabs -->
                <div class="timing-tabs tabs-box">

                    <!--Tab Btns-->
                    <ul class="tab-btns tab-buttons clearfix">
                        <li data-tab="#prod-events" class="tab-btn active-btn">ALL EVENTS</li>
                        <li data-tab="#prod-cardio" class="tab-btn">CARDIO</li>
                        <li data-tab="#prod-gross" class="tab-btn">CROSSFIT</li>
						<li data-tab="#prod-gym" class="tab-btn">GYM</li>
                        <li data-tab="#prod-power" class="tab-btn">POWERLIFTING</li>
                    </ul>

                    <!-- Tabs Container -->
                    <div class="tabs-content">

                        <!--Tab / Active Tab-->
                        <div class="tab active-tab" id="prod-events">
                            <div class="content">
								<div class="table-image">
									<img src="{{ asset('frontend/assets/images/resource/table.jpg') }}" alt="" />
								</div>
							</div>
						</div>

						<!--Tab-->
                        <div class="tab" id="prod-cardio">
                            <div class="content">
								<div class="table-image">
									<img src="{{ asset('frontend/assets/images/resource/table.jpg') }}" alt="" />
								</div>
							</div>
						</div>

						<!--Tab-->
                        <div class="tab" id="prod-gross">
                            <div class="content">
								<div class="table-image">
									<img src="{{ asset('frontend/assets/images/resource/table.jpg') }}" alt="" />
								</div>
							</div>
						</div>

						<!--Tab-->
                        <div class="tab" id="prod-gym">
                            <div class="content">
								<div class="table-image">
									<img src="{{ asset('frontend/assets/images/resource/table.jpg') }}" alt="" />
								</div>
							</div>
						</div>

						<!--Tab-->
                        <div class="tab" id="prod-power">
                            <div class="content">
								<div class="table-image">
									<img src="{{ asset('frontend/assets/images/resource/table.jpg') }}" alt="" />
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>

		</div>
	</section>
	<!-- End Timing Section -->

@endsection
