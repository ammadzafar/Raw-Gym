@extends('layouts.master')

@section('title', $product->name . ' | Edit')

@section('css')
    <link href="{{URL::asset('/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Products @endslot
        @slot('li_1') {{ $product->name }} @endslot
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

                        <form id="update-product">
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
                                                           data-parsley-trigger="keyup" value="{{ $product->name }}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Slug</label>
                                                    <input name="slug" type="text" class="form-control"
                                                           placeholder="Slug" value="{{ $product->slug }}"
                                                           data-parsley-trigger="keyup">
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
                                                                    value="{{ $brand->id }}" {{ $brand->id === $product->brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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
                                                                    value="{{ $category->id }}" {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                            @if($product->images->count())
                                                <div class="col-md-12">
                                                    <label>Previous images</label>
                                                    <div class="row">
                                                        @foreach($product->images as $image)
                                                            <div class="col-md-3">
                                                                <img src="{{ asset($image->path) }}" class="w-100 img-thumbnail" alt="">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="advance" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Select Attribute's<span class="text-danger">*</span></label>
                                                    <select class=" form-control select2-multiple" multiple
                                                            id="selectAttributes" required>
                                                        {{--  <option selected disabled>Select Attributes</option>--}}
                                                        @if($attributes->count())
                                                            @foreach($attributes as $attribute)
                                                                <option
                                                                    value="{{ $attribute->id }}" {{ in_array($attribute->id, $selectedAttributes) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="makeVariations">

                                                @if($product->variants->count())
                                                    @forelse($product->variants as $key => $variant)
                                                        <div class="row border mb-2">
                                                            <div class="col-md-12">
                                                                <div class="row bg-light p-2 mb-2">
                                                                    <div
                                                                        class="col-md-1 border-dark border-right text-center">
                                                                        <span><b>{{ $loop->iteration }}</b></span>
                                                                    </div>
                                                                    <div class="col-md-11">
                                                                        <div class="row">
                                                                            @forelse($variant->values as $inner_key => $value)
                                                                                <div class="col-md-4">
                                                                                    <input type="hidden"
                                                                                           name="variants[{{ $key }}][values][]"
                                                                                           value="{{ $value->id }}"
                                                                                           required>
                                                                                    <h6 class="m-0">{{ $value->attribute->name }}
                                                                                        : {{ $value->name }}</h6>
                                                                                </div>
                                                                            @empty
                                                                                <div class="col-md-4">
                                                                                    <h6 class="m-0">No variant
                                                                                        name!</h6>
                                                                                </div>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Price<span
                                                                            class="text-danger">*</span></label>
                                                                    <input name="variants[{{ $key }}][price]"
                                                                           type="number"
                                                                           class="form-control"
                                                                           value="{{ $variant->price }}"
                                                                           placeholder="price" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>SKU<span class="text-danger">*</span></label>
                                                                    <input name="variants[{{ $key }}][sku]" type="text"
                                                                           class="form-control" placeholder="SKU"
                                                                           value="{{ $variant->sku }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Stock<span
                                                                            class="text-danger">*</span></label>
                                                                    <input name="variants[{{ $key }}][stock]"
                                                                           type="number"
                                                                           class="form-control"
                                                                           value="{{ $variant->stock }}"
                                                                           placeholder="Stock" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Status<span
                                                                            class="text-danger">*</span></label>
                                                                    <select name="variants[{{ $key }}][status]"
                                                                            class="form-control">
                                                                        <option
                                                                            value="in_stock" {{ $variant->status === 'in_stock' ? 'selected' : '' }}>
                                                                            In Stock
                                                                        </option>
                                                                        <option
                                                                            value="out_of_stock" {{ $variant->status === 'out_of_stock' ? 'selected' : '' }}>
                                                                            Out of Stock
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span><b>No variant found!</b></span>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div id="seo" class="tab-pane fade">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Seo Title</label>
                                                <input name="seo_title" type="text" class="form-control"
                                                       placeholder="Seo Title" value="{{ $product->seo_title }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Seo keywords</label>
                                                <textarea name="seo_keywords" type="text" class="form-control"
                                                          placeholder="Seo keywords">{{ $product->seo_keywords }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Seo Description</label>
                                                <textarea name="seo_description" type="text" class="form-control"
                                                          placeholder="Seo Description">{{ $product->seo_description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tags<span class="text-danger">*</span></label>
                                                <select class="form-control select2-multiple"
                                                        name="tags[]" data-placeholder="Choose ..." multiple
                                                        id="tags" data-parsley-required="true">
                                                    @if($tags->count())
                                                        @foreach($tags as $tag)
                                                            <option
                                                                value="{{ $tag->id }}" {{ in_array($tag->id, $product->tags->pluck('id')->toArray()) ? 'selected' : '' }}>{{$tag->name}}</option>
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
@include('backend.product.ajax.edit')
