@extends('layouts.main')


@section('content')

<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('site.editproduct')</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

            <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('partials._errors')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.categories')</label>
                            <select name="category_id" class="form-control">
                                <option value="">@lang('site.categories')</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : ''}}>{{
                                    $category->category_name }} {{
                                    $category->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.codebar')</label>
                            <div style="display: flex;">
                                <input type="text" name="codebar" id="bar" class="form-control bar"
                                    value="{{ $product->codebar }}">
                                <button type="button" id="button_barcode"
                                    class="btn btn-primary float-right">@lang('site.generatecodebar')</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.productname')</label>
                            <input type="text" name="product_name" id="" class="form-control"
                                value="{{ $product->product_name }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.description')</label>
                            <input type="textarea" name="description" id="" class="form-control"
                                value="{{ $product->description }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.purchaseprice')</label>
                            <input type="number" name="purchase_price" id="" class="form-control"
                                value="{{ $product->purchase_price }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.saleprice')</label>
                            <input type="number" name="sale_price" id="" class="form-control"
                                value="{{ $product->sale_price }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.stock')</label>
                            <input type="number" name="stock" id="" class="form-control" value="{{ $product->stock }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.minstock')</label>
                            <input type="number" name="min_stock" id="" class="form-control"
                                value="{{ $product->min_stock }}">
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="form-control image custom-file-input"
                                    id="customFile">
                                <label class="custom-file-label" for="customFile">@lang('site.choosephoto')</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <img src="{{ $product->image_path }}" style="width:200px;"
                                class="img-circle img-thumbnail img-preview">
                        </div>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>
                        @lang('site.updateproduct')</button>
                </div>
            </form>

        </div>
        <!-- /.card-body -->

    </div>
</div>


@stop
