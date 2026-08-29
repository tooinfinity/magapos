@extends('layouts.main')


@section('content')
@include('sweetalert::alert')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">
            <h2>@lang('site.boxmoney')</h2>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div id="category_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="category_table"
                            class="table table-responsive-sm table-bordered table-striped table-hover  dataTable"
                            role="grid" aria-describedby="category_table_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Rendering engine: activate to sort column descending"
                                        style="width: 283px;">@lang('site.transactionname')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending"
                                        style="width: 359px;">@lang('site.transactiontype')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                        style="width: 320px;">@lang('site.inputoutput')</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($salemoneys as $index => $salemoney)
                                <tr>
                                    <td><span class="badge bg-success">{{ $index + 1 }}- @lang('site.sale')</span></td>
                                    <td><span class="badge bg-success">{{ $salemoney->number_sale }}</span></td>
                                    <td><span class="badge bg-success">{{ $salemoney->total_amount }}</span></td>
                                </tr>
                                @endforeach
                                @foreach ($purchasemoneys as $index => $purchasemoney)
                                <tr>
                                    <td><span class="badge bg-warning">{{ $index + 1 }}- @lang('site.purchase')</span>
                                    </td>
                                    <td><span class="badge bg-warning">{{ $purchasemoney->number_purchase }}</span></td>
                                    <td><span class="badge bg-warning">{{ $purchasemoney->total_amount }}</span></td>
                                </tr>
                                @endforeach
                                @foreach ($spendmoneys as $index => $spendmoney)
                                <tr>
                                    <td><span class="badge bg-danger">{{ $index + 1 }}- @lang('site.spending')</span>
                                    </td>
                                    <td><span class="badge bg-danger">{{ $spendmoney->spending_name }}</span>
                                    </td>
                                    <td><span class="badge bg-danger">{{ $spendmoney->spending_price }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">@lang('site.transactionname')</th>
                                    <th rowspan="1" colspan="1">@lang('site.transactiontype')</th>
                                    <th rowspan="1" colspan="1">@lang('site.inputoutput')</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-primary">
        <div class="card-header with-border">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-success col-md-12">@lang('site.totalsalemoney') :
                                {{ $totalsalemoneys }}</span></h4>
                    </div>
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-warning col-md-12">@lang('site.totalpurchasemoney') :
                                {{ $totalpurchasemoneys }}</span>
                        </h4>
                    </div>
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-danger col-md-12">@lang('site.totalcreditprovidermoney') :
                                {{ $totalpurchaseduemoneys }}</span>
                        </h4>
                    </div>
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-danger col-md-12">@lang('site.totalcreditclientmoney') :
                                {{ $totalsaleduemoneys }}</span>
                        </h4>
                    </div>
                    <div class="text-center">
                        <h4><span class="badge p-2 bg-danger col-md-12">@lang('site.totalspendingmoney') :
                                {{ $totalspendmoneys }}</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1><span class="badge bg-white col-md-12">@lang('site.totalboxmoney') :
                            {{ $totalboxmoneys }}</span></h1>
                </div>

            </div>
        </div>
    </div>
</div>


@stop
