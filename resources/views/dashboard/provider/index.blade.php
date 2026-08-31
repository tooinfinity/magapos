@extends('layouts.main')


@section('content')
@include('sweetalert::alert')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">

            <form action="{{ route('provider.index') }}" method="get">

                <div class="row no-gutters">
                    <div class="col-12 col-sm-6 col-md-8">
                        <h3 class="card-title">@lang('site.providers')</h3>
                    </div>
                    <div class="col-6 col-md-4">
                        @if (auth()->user()->hasPermission('create_providers'))
                        <a type="" class="btn btn-success btn float-right" style=""
                            href="{{ route('provider.create') }}"><i <i class="nav-icon fas fa-truck"></i>
                            @lang('site.createprovider')</a>
                        @else
                        <a type="" class="btn btn-success disabled btn float-right" href="#"><i
                                class="nav-icon fas fa-truck"></i>
                            @lang('site.createprovider')</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div id="provider_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="provider_table" class="table table-bordered table-striped table-hover  dataTable"
                            role="grid" aria-describedby="provider_table_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="provider_table" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Rendering engine: activate to sort column descending"
                                        style="width: 283px;">No</th>
                                    <th class="sorting" tabindex="0" aria-controls="provider_table" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending"
                                        style="width: 359px;">@lang('site.providername')</th>
                                    <th class="sorting" tabindex="0" aria-controls="provider_table" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                        style="width: 250px;">@lang('site.phone')</th>
                                    <th class="sorting" tabindex="0" aria-controls="provider_table" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                        style="width: 250px;">@lang('site.address')</th>
                                    <th class="sorting" tabindex="0" aria-controls="client_table" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                        style="width: 250px;">dues Sales</th>
                                    <th class="sorting" tabindex="0" aria-controls="client_table" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                        style="width: 250px;">details Sales</th>
                                    <th class="sorting" tabindex="0" aria-controls="client_table" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 243px;">@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($providers as $index => $provider)

                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $provider -> provider_name }}</td>
                                    <td>{{ $provider -> phone }}</td>
                                    <td>{{ $provider -> address }}</td>
                                    <td>{{ $provider ->purchases->sum('due') }}</td>
                                    <td>@if ($provider ->purchases->count() > 0)
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('provider.detail', $provider->id) }}">details of
                                            {{ $provider ->purchases->count() }} purchases</i></a>
                                        @else
                                        <a class="btn btn-primary btn-sm disabled"
                                            href="{{ route('provider.edit', $provider->id) }}">details of
                                            {{ $provider ->purchases->count() }} purchases</i></a>
                                        @endif</td>
                                    <td>
                                        @if (auth()->user()->hasPermission('update_providers') && $provider->id != 1)
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('provider.edit', $provider->id) }}"><i
                                                class="fas fa-edit"></i>
                                            @lang('site.edit')</a>
                                        @else
                                        <a class="btn btn-warning btn-sm disabled"
                                            href="{{ route('provider.edit', $provider->id) }}"><i
                                                class="fas fa-edit"></i>
                                            @lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission('delete_providers') && $provider->id != 1)
                                        <button id="delete" onclick="deletemoderator({{ $provider->id }})"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                            @lang('site.delete')</button>
                                        <form id="form-delete-{{ $provider->id }}"
                                            action="{{ route('provider.destroy', $provider->id) }}" method="post"
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
                                    <th rowspan="1" colspan="1">@lang('site.providername')</th>
                                    <th rowspan="1" colspan="1">@lang('site.phone')</th>
                                    <th rowspan="1" colspan="1">@lang('site.address')</th>
                                    <th rowspan="1" colspan="1">dues sales</th>
                                    <th rowspan="1" colspan="1">details sales</th>
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
