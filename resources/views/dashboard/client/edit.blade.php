@extends('layouts.main')


@section('content')

<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('site.editclient')</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">

            <form action="{{ route('client.update', $client->id) }}" method="post">
                @csrf
                @method('put')
                @include('partials._errors')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.clientname')</label>
                            <input type="text" name="client_name" id="" class="form-control"
                                value="{{ $client->client_name }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.phone')</label>
                            <input type="text" name="phone" id="" class="form-control" value="{{ $client->phone }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.address')</label>
                            <textarea type="text" name="address" id=""
                                class="form-control">{{ $client->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.description')</label>
                            <textarea type="text" name="description" id=""
                                class="form-control">{{ $client->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.numeroregistrecommerce')</label>
                            <input type="text" name="rc" id="" class="form-control" value="{{ $client->rc }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.numeroarticle')</label>
                            <input type="number" name="article" id="" class="form-control"
                                value="{{ $client->article }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.nif')</label>
                            <input type="number" name="nif" id="" class="form-control" value="{{ $client->nif }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.nis')</label>
                            <input type="number" name="nis" id="" class="form-control" value="{{ $client->nis }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>
                        @lang('site.updateclient')</button>
                </div>
            </form>

        </div>
        <!-- /.card-body -->

    </div>
</div>


@stop
