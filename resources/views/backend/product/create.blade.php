@extends('layouts.master')

@section('title', 'Add Product')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Products @endslot
        @slot('li_1') Add Product @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">

                        <ul class="nav nav-pills justify-content-center">
                            <li>
                                <a class="nav-link active" data-toggle="pill" href="#basic">Basic</a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="pill" href="#advance">Variations</a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="pill" href="#seo">SEO</a>
                            </li>
                        </ul>

                        <form id="create-product">
                            @csrf
                            <div class="row">
                                <div class="tab-content formStyle">
                                    <div id="basic" class="tab-pane active">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Name<span class="text-danger">*</span></label>
                                                    <input name="name" type="text" class="form-control"
                                                           placeholder="Name" required
                                                           data-parsley-trigger="keyup"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Slug</label>
                                                    <input name="slug" type="text" class="form-control"
                                                           placeholder="Slug">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Brand<span class="text-danger">*</span></label>
                                                    <select class="form-control select2-multiple" name="brand_id"
                                                            required>
                                                        @if($brands->count())
                                                            @foreach($brands as $brand)
                                                                <option
                                                                    value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Parent Category</label>
                                                    <select class="form-control select2-multiple category-on-change">
                                                        @if($categories->count())
                                                            @foreach($categories as $category)
                                                                <option
                                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Sub-Category<span class="text-danger">*</span></label>
                                                    <select class=" form-control select2-multiple" id="child_categories"
                                                            name="categories[]" required>
                                                        @if($categories->first())
                                                            @foreach($categories->first()->subCategories as $category)
                                                                <option
                                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Images</label>
                                                    <input name="images[]" class="form-control" type="file"
                                                           accept="image/*" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="advance" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Select Attribute's<span class="text-danger">*</span></label>
                                                    <select class=" form-control select2-multiple" multiple data-placeholder="Choose ..."
                                                            id="selectAttributes" required>
                                                        {{--  <option selected disabled>Select Attributes</option>--}}
                                                        @if($attributes->count())
                                                            @foreach($attributes as $attribute)
                                                                <option
                                                                    value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="makeVariations">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="seo" class="tab-pane fade">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Seo Title</label>
                                                <input name="seo_title" type="text" class="form-control"
                                                       placeholder="Seo Title">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Seo keywords</label>
                                                <textarea name="seo_keywords" type="text" class="form-control"
                                                          placeholder="Seo keywords" rows="1"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Seo Description</label>
                                                <textarea name="seo_description" type="text" class="form-control"
                                                          placeholder="Seo Description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tags<span class="text-danger">*</span></label>
                                                <select class="form-control select2-multiple"
                                                        name="tags[]" data-placeholder="Choose ..." multiple
                                                        id="tags" required>
                                                    @if($tags->count())
                                                        @foreach($tags as $tag)
                                                            <option value="{{ $tag->id }}">{{$tag->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group text-right">
                                            <button type="reset" class="btn btn-outline-dark waves-effect">Reset
                                            </button>
                                            <button type="submit"
                                                    class="btn btn-dark bg-dark-red waves-effect waves-light mr-1"
                                                    data-size="xs">
                                                Create
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('backend.product.ajax.create')
