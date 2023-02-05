@extends('frontend.layouts.master')

@section('content')
    <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x960)">
        <div class="auto-container">
            <h2>WRONG PAGE</h2>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>404</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!--Error Section-->
    <section class="error-section">
        <div class="auto-container">
            <div class="content">
                <h1>404</h1>
                <div class="image">
                    <img src="https://via.placeholder.com/788x462" alt=""/>
                </div>
                <a href="index.html" class="theme-btn btn-style-two"><span class="txt">Go to home page</span></a>
            </div>
        </div>
    </section>
    <!--End Error Section-->

@endsection
