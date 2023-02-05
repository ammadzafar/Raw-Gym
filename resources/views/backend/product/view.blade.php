@extends('layouts.master')

@section('title') {{$product->name}} @endsection

@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') {{$product->name}}  @endslot
        @slot('li_1') Pages  @endslot
    @endcomponent

    <!-- start row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="popup-gallery">
                                <div class="row justify-content-center">
                                    @forelse($product->images as $image)
                                        <div class="col-md-4 p-0">
                                            <a class="float-left w-100" href="{{ asset($image->path) }}"
                                               title="{{ $product->name }}">
                                                <div class="img-fluid w-100" style="height: 100px">
                                                    <img src="{{ asset($image->path) }}" class="w-100 h-100" alt="">
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-md-4 p-0">
                                            <h5>No image found!</h5>
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1>{{ $product->name }}</h1>
                            <div class="">
                                <p><b>Slug: </b>{{ $product->slug }}</p>
                                <p><b>Brand: </b>{{ @$product->brand->name }}</p>
                                <p><b>Category: </b>
                                    @forelse($product->categories as $category)
                                        <span class="badge badge-dark">{{ $category->name }}</span>
                                    @empty
                                        <span>No category!</span>
                                    @endforelse
                                </p>
                                <p><b>Tags: </b>
                                    @forelse($product->tags as $tag)
                                        <span class="badge badge-dark">{{ $tag->name }}</span>
                                    @empty
                                        <span>No tag!</span>
                                    @endforelse
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
            <h3>Variations</h3>
        </div>

        @forelse($product->variants as $variant)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-widgets">

                            <div class="">
                                <p><b>{{ $loop->iteration }}</b></p>
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
                        <h5>No variation found!</h5>
                    </div>
                </div>
            </div>
        @endforelse

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3>SEO</h3>
                    <div class="">
                        <p class="m-0"><b>Title</b></p>
                        <p>{{ $product->seo_title }}</p>
                        <p class="m-0"><b>Keywords</b></p>
                        <p>{{ $product->seo_keywords }}</p>
                        <p class="m-0"><b>Description</b></p>
                        <p>{{ $product->seo_description }}</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- end row -->
@endsection
@section('script')
    <script src="{{URL::asset('/libs/magnific-popup/magnific-popup.min.js')}}"></script>

    <script>
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image

            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            },
            zoom: {
                enabled: true,
                duration: 300,
                // don't foget to change the duration also in CSS
                opener: function opener(element) {
                    return element.find('img');
                }
            }
        });
    </script>
@endsection

