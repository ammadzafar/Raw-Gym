@extends('layouts.master')

@section('title') Dashboard @endsection

@section('content')
@component('common-components.breadcrumb')
@slot('title') Dashboard   @endslot
@slot('title_li') Dashboard   @endslot
@endcomponent

<div class="row">

    <div class="col-12">
        <h5>{{\Carbon\Carbon::now()->format('d F Y')}}</h5>
    </div>

    <div class="col-xl-3">
        @component('common-components.dashboard2-revenue-widget')
            @slot('title') New Customer @endslot
            @slot('total') {{$newcustomer}} @endslot
            @slot('percentage') 2.12 %  @endslot
            @slot('pClass') progress-bar bg-success  @endslot
            @slot('pValue') 75 @endslot
        @endcomponent
    </div>
    <div class="col-xl-3">
        @component('common-components.dashboard2-revenue-widget')
            @slot('title')Current Month Income  @endslot
            @slot('total') {{$currentmonthincome}}@endslot
            @slot('percentage') 2.12 %  @endslot
            @slot('pClass') progress-bar bg-success  @endslot
            @slot('pValue') 75 @endslot
        @endcomponent
    </div>
    <div class="col-xl-3">
        @component('common-components.dashboard2-revenue-widget')
            @slot('title') Total Customer  @endslot
            @slot('total') {{$customer}}  @endslot
            @slot('percentage') 2.06 %  @endslot
            @slot('pClass') progress-bar bg-purple  @endslot
            @slot('pValue') 62 @endslot
        @endcomponent
    </div>

    <div class="col-xl-3">
        @component('common-components.dashboard2-revenue-widget')
        @slot('title') Total Users @endslot
        @slot('total') {{$user}}@endslot
        @slot('percentage') 3.12 %  @endslot
        @slot('pClass') progress-bar bg-warning  @endslot
        @slot('pValue') 78 @endslot
        @endcomponent


    </div>

    <div class="col-xl-3">
        @component('common-components.dashboard2-revenue-widget')
            @slot('title') Total Roles  @endslot
            @slot('total') {{$role}}@endslot
            @slot('percentage') 2.12 %  @endslot
            @slot('pClass') progress-bar bg-success  @endslot
            @slot('pValue') 75 @endslot
        @endcomponent
    </div>



    <div class="col-xl-3">
        @component('common-components.dashboard2-revenue-widget')
            @slot('title') Total Income  @endslot
            @slot('total') {{$totalincome}}@endslot
            @slot('percentage') 2.12 %  @endslot
            @slot('pClass') progress-bar bg-success  @endslot
            @slot('pValue') 75 @endslot
        @endcomponent
    </div>
    <div class="col-xl-3">
        @component('common-components.dashboard2-revenue-widget')
            @slot('title')Membership @endslot
                Total Membership :
            @slot('total')


                    @endslot
            @slot('membershipname')

                @endslot
            @slot('percentage') 2.12 %  @endslot
            @slot('pClass') progress-bar bg-success  @endslot
            @slot('pValue') 75 @endslot
        @endcomponent
    </div>

   {{-- <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Earning</h4>

                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <p>1 Jan - 31 Jan, 2020</p>
                            <p class="mb-2">Total Earning</p>
                            <h4>$ 12,362</h4>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mt-3">
                                    <p class="mb-2 text-truncate">This Month</p>
                                    <h5 class="d-inline-block align-middle mb-0">$ 9,245</h5> <span class="badge badge-soft-success">+ 1.5 %</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mt-3">
                                    <p class="mb-2 text-truncate">Last Month</p>
                                    <h5>$ 8,234</h5>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="#" class="btn btn-primary btn-sm">View more</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <div id="bar-chart" class="apex-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

</div>
<!-- end row -->

<!-- end row -->

@endsection
