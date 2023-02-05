@extends('layouts.master')

@section('title') {{$order->order_at}} @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') {{ $order->order_at }}  @endslot
        @slot('li_1') Pages  @endslot
    @endcomponent

    <!-- start row -->
    <div class="row">

        <div class="col-12">
            <h3>Customer Details</h3>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="">
                                <p><b>Name: </b>{{ $order->customer->name }}</p>
                                <p><b>Phone: </b>{{ $order->customer->phone }}</p>
                                <p><b>Email: </b>{{ $order->customer->email }}</p>
                                <p><b>More Info: </b><a href="{{ route('member.show', $order->customer->id) }}"
                                                        target="_blank">{{ route('member.show', $order->customer->id) }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h3>Order Details</h3>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3>SEO</h3>
                    <div class="row d-flex">
                        <div class="col-md-6">
                            <p class="m-0"><b>Order At</b></p>
                            <p>{{ $order->order_at }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="m-0"><b>Current Status</b></p>
                            <p>{{ $order->status }}</p>
                        </div>
                        <div class="col-12">
                            <p class="m-0"><b>Address</b></p>
                            <p>{{ $order->address }}</p>
                        </div>
                        <div class="col-12">
                            <p class="m-0"><b>Comment</b></p>
                            <p>{{ $order->comment }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @forelse($order->orderDetails as $variant)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-widgets">

                            <div class="">
                                <p><b>Qty. {{ $variant->pivot->quantity }}</b></p>
                                <p><b>Amount: {{ $variant->pivot->total_amount }}</b></p>
                                <div class="mt-3 text-left">
                                    <div class="border-bottom">
                                        @forelse($variant->values as $inner_key => $value)
                                            <p href="#"
                                               class="text-dark font-weight-medium m-0">{{ $value->attribute->name }}
                                                : {{ $value->name }}</p>
                                        @empty
                                            <span class="text-dark font-weight-medium font-size-16">No name!</span>
                                        @endforelse
                                    </div>
                                    <p class="text-body mt-1 mb-1"><b>SKU: </b>{{ $variant->sku }}</p>
                                    <p class="text-body mt-1 mb-1"><b>Stock: </b>{{ $variant->stock }}</p>
                                    <p class="text-body mt-1 mb-1"><b>Price: </b>{{ $variant->price }}</p>
                                </div>
                                <div class="mt-2 text-center">
                                    <span
                                        class="badge badge-{{ $variant->status === 'in_stock' ? 'success' : 'danger' }}">{{ $variant->status }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>No details found!</h5>
                    </div>
                </div>
            </div>
        @endforelse

    </div>

    <!-- end row -->
@endsection
@section('script')
    <script src="{{URL::asset('/libs/magnific-popup/magnific-popup.min.js')}}"></script>
@endsection

