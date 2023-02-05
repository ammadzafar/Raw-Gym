@extends('layouts.master')

@section('title', 'Products')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Products @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @can('product_create')
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{route('product.create')}}"><button class="btn btn-dark bg-dark-red btn-sm"
                                id="create-new-product">Create
                            Product
                        </button></a>

                        </div>
                    @endcan
                    <table class="table datatable table-bordered dt-responsive nowrap w-100"
                           style="border-collapse: collapse; border-spacing: 0;">
                        <thead>
                        <tr>
                            <th>Register</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="edit-product-modal" tabindex="-1" role="dialog"
         aria-labelledby="edit-product"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="edit-product">Edit product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-product">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" id="edit_product_name"
                                           placeholder="Name" data-parsley-required="true" data-parsley-trigger="keyup">
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label>Parent product</label>
                                    <select class=" form-control select2-multiple" name="product_id" id="edit_product_id">
                                            <option value="">Select Parent product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input name="slug" type="text" class="form-control" id="edit_product_slug"
                                           placeholder="Slug">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input name="image" type="file" class="form-control" id="edit_product_image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="submit"
                                            class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner" data-size="xs">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('backend.product.ajax.index')


