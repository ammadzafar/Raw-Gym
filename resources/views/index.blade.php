@extends('layouts.master')

@section('title') Dashboard @endsection

@section('content')

    @component('common-components.breadcrumb')
         @slot('title') Dashboard   @endslot
         @slot('title_li') Welcome to musclebarfitness Dashboard   @endslot
     @endcomponent

                    <div class="row">




                    </div>
                    <!-- end row -->


                    <!-- end row -->


                    <!-- end row -->


                    <!-- end row -->
@endsection

@section('script')
        <!-- plugin js -->
        <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- jquery.vectormap map -->
        <script src="{{ URL::asset('libs/jquery-vectormap/jquery-vectormap.min.js')}}"></script>

        <!-- Calendar init -->
        <script src="{{ URL::asset('js/pages/dashboard.init.js')}}"></script>

@endsection

