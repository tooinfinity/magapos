@extends('layouts.main')


@section('content')
@include('sweetalert::alert')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">

            <form action="{{ route('product.index') }}" method="get">

                <div class="row no-gutters">
                    <div class="col-12 col-sm-6 col-md-8">
                        <h3 class="card-title">@lang('site.products')</h3>
                    </div>
                    <div class="col-6 col-md-4">
                        @if (auth()->user()->hasPermission('create_products'))
                        <a type="" class="btn btn-success btn float-right" style=""
                            href="{{ route('product.create') }}"><i class="fas fa-user-plus"></i>
                            @lang('site.createproduct')</a>
                        @else
                        <a type="" class="btn btn-success disabled btn float-right" href="#"><i
                                class="fas fa-user-plus"></i>
                            @lang('site.createproduct')</a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                            value="{{ request()->search }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <select name="category_id" class="form-control">
                            <option value="">@lang('site.categories')</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request()->category_id == $category->id ? 'selected' : ''}}>{{
                                $category->category_name }} {{
                                $category->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <button type="submit" class="btn btn-success float-left"><i class="fas fa-search"></i>
                            @lang('site.search') </button>
                    </div>


                </div>

        </div>
        </form>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <div id="product_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <table id="product_table" class="table table-bordered table-striped table-hover  dataTable"
                        role="grid" aria-describedby="product_table_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="product_table" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending"
                                    style="width: 283px;">No</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending" style="width: 359px;">
                                    @lang('site.codebar')</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="width: 283px;">
                                    @lang('site.productname')</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="width: 283px;">
                                    @lang('site.description')</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="width: 283px;">
                                    @lang('site.purchaseprice')</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="width: 283px;">
                                    @lang('site.saleprice')</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="width: 283px;">
                                    @lang('site.stock')</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="width: 320px;">
                                    @lang('site.photo')</th>
                                <th class="sorting" tabindex="0" aria-controls="product_table" rowspan="1" colspan="1"
                                    aria-label="Engine version: activate to sort column ascending"
                                    style="width: 359px;">@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $index => $product)

                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product -> codebar }}</td>
                                <td>{{ $product -> product_name }}</td>
                                <td>{{ $product -> description }}</td>
                                <td>{{ $product -> purchase_price }}</td>
                                <td>{{ $product -> sale_price }}</td>
                                <td>{{ $product -> stock }}</td>
                                <td><img src="{{ $product -> image_path }}" style="width:50px;"
                                        class="img-circle img-thumbnail" alt=""></td>
                                <td>
                                    @if (auth()->user()->hasPermission('update_categories'))
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ route('product.edit', $product->id) }}"><i class="fas fa-edit"></i>
                                        @lang('site.edit')</a>
                                    @else
                                    <a class="btn btn-warning btn-sm disabled"
                                        href="{{ route('product.edit', $product->id) }}"><i class="fas fa-edit"></i></i>
                                        @lang('site.edit')</a>
                                    @endif
                                    @if (auth()->user()->hasPermission('delete_products'))
                                    <button id="delete" onclick="deletemoderator({{ $product->id }})"
                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                        @lang('site.delete')</button>
                                    <form id="form-delete-{{ $product->id }}"
                                        action="{{ route('product.destroy', $product->id) }}" method="post"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('delete')
                                    </form>
                                    @else
                                    <button type="submit" class="btn btn-danger btn-sm disabled"><i
                                            class="fas fa-trash"></i>
                                        @lang('site.delete')</button>
                                    @endif

                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">No</th>
                                <th rowspan="1" colspan="1">@lang('site.codebar')</th>
                                <th rowspan="1" colspan="1">@lang('site.productname')</th>
                                <th rowspan="1" colspan="1">@lang('site.description')</th>
                                <th rowspan="1" colspan="1">@lang('site.purchaseprice')</th>
                                <th rowspan="1" colspan="1">@lang('site.saleprice')</th>
                                <th rowspan="1" colspan="1">@lang('site.stock')</th>
                                <th rowspan="1" colspan="1">@lang('site.photo')</th>
                                <th rowspan="1" colspan="1">@lang('site.action')</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->


</div>


@stop
