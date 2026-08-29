@extends('layouts.main')


@section('content')

<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('site.createcategory')</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

            <form action="{{ route('category.store') }}" method="post">
                @csrf
                @method('post')
                @include('partials._errors')
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.categoryname')</label>
                            <input type="text" name="category_name" id="" class="form-control"
                                value="{{ old('category_name') }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.brandname')</label>
                            <input type="text" name="brand_name" id="" class="form-control"
                                value="{{ old('brand_name') }}">
                        </div>

                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="submit" class="btn btn-success" href="{{ route('category.store') }}"><i
                            class="fas fa-user-plus"></i>
                        @lang('site.newcategory')</button>
                </div>
            </form>

        </div>
        <!-- /.card-body -->

    </div>
</div>


@stop
