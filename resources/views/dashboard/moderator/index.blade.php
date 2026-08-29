@extends('layouts.main')


@section('content')
@include('sweetalert::alert')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">

            <form action="{{ route('product.index') }}" method="get">

                <div class="row no-gutters">
                    <div class="col-12 col-sm-6 col-md-8">
                        <h3 class="card-title">@lang('site.moderators')</h3>
                    </div>
                    <div class="col-6 col-md-4">
                        @if (auth()->user()->hasPermission('create_users'))
                        <a type="" class="btn btn-success btn float-right" style="" href="{{ route('moderator.create') }}"><i
                                class="fas fa-user-plus"></i>
                            @lang('site.createmoderator')</a>
                        @else
                        <a type="" class="btn btn-success disabled btn float-right" href="#"><i class="fas fa-user-plus"></i>
                            @lang('site.createmoderator')</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div id="category_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="category_table" class="table table-bordered table-striped table-hover  dataTable"
                            role="grid" aria-describedby="category_table_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"
                                        style="width: 283px;">No</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1" colspan="1"
                                        aria-label="Browser: activate to sort column ascending" style="width: 359px;">@lang('site.firstname')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1" colspan="1"
                                        aria-label="Platform(s): activate to sort column ascending" style="width: 320px;">@lang('site.lastname')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1" colspan="1"
                                        aria-label="Platform(s): activate to sort column ascending" style="width: 320px;">@lang('site.email')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1" colspan="1"
                                        aria-label="Platform(s): activate to sort column ascending" style="width: 320px;">@lang('site.photo')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1" colspan="1"
                                        aria-label="Engine version: activate to sort column ascending" style="width: 243px;">@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($moderator as $index => $moderators)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $moderators -> first_name }}</td>
                                    <td>{{ $moderators -> last_name }}</td>
                                    <td>{{ $moderators -> email }}</td>
                                    <td><img src="{{ $moderators -> image_path }}" style="width:50px;" class="img-circle img-thumbnail"
                                            alt="" srcset=""></td>
                                    <td>
                                        @if (auth()->user()->hasPermission('update_users'))
                                        <a class="btn btn-warning btn-sm" href="{{ route('moderator.edit', $moderators->id) }}"><i
                                                class="fas fa-user-edit"></i>
                                            @lang('site.edit')</a>
                                        @else
                                        <a class="btn btn-warning btn-sm disabled" href="{{ route('moderator.edit', $moderators->id) }}"><i
                                                class="fas fa-user-edit"></i>
                                            @lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission('delete_users'))
                                        <button id="delete" onclick="deletemoderator({{ $moderators->id }})" class="btn btn-danger btn-sm"><i
                                                class="fas fa-user-times"></i>
                                            @lang('site.delete')</button>
                                        <form id="form-delete-{{ $moderators->id }}" action="{{ route('moderator.destroy', $moderators->id) }}"
                                            method="post" style="display:inline-block;">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        @else
                                        <button type="submit" class="btn btn-danger btn-sm disabled"><i class="fas fa-user-times"></i>
                                            @lang('site.delete')</button>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">No</th>
                                    <th rowspan="1" colspan="1">@lang('site.firstname')</th>
                                    <th rowspan="1" colspan="1">@lang('site.lastname')</th>
                                    <th rowspan="1" colspan="1">@lang('site.email')</th>
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
</div>


@stop
