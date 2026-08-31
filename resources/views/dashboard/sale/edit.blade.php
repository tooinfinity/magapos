@extends('layouts.pos')


@section('content')

<div class="col-md-6">
    <div class="card card-primary card-outline" style="height:80vh;">
        <div class="card-header">
            <h3 class="card-title">@lang('site.productssale')</h3>

        </div> <!-- /.card-body -->
        <div class="card-body" style="overflow-y:scroll;">
            <form action="{{ route('sale.update', $sale->id) }}" method="post">

                @csrf
                @method('put')

                @include('partials._errors')
                <div class="row">
                    <div class="col-md-6">
                        <div id="client" class="form-group">
                            <label for="">@lang('site.selectclient')</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="client_id" class="form-control">
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ $clientsel->id == $client->id ? 'selected' : ''}}>{{
                                    $client->client_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target=".bd-example-modal-lg-client">@lang('site.addclient')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.numbersale') : </label>
                            <input type="text" name="number_sale" class="form-control text-center" readonly
                                value="{{ $sale->number_sale }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <table id="sale" class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('site.productname')</th>
                                <th>@lang('site.quantitysale')</th>
                                <th>@lang('site.saleprice')</th>
                                <th style="width: 25px;">@lang('site.delete')</th>
                            </tr>
                        </thead>

                        <tbody class="order-list">
                            @foreach ($sale->products as $product)
                            <tr id="{{ $product->id }}" class="form-group items">
                                <td id="name" class="namex">{{ $product->product_name }}</td>
                                <input type="hidden" name="product[]" value="{{ $product->id }}">
                                <td style="display: flex;">
                                    <input id="qty" style="width: 60% !important;" type="number" name="quantity[]"
                                        data-price="{{ $product->sale_price }}" data-stock="{{ $product->stock }}"
                                        class="form-control input-sm product-quantity" min="1"
                                        max="{{ $product->stock }}" value="{{ $product->pivot->quantity }}">
                                </td>
                                <td class="product-price">{{ $product->sale_price * $product->pivot->quantity }}</td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-product-btn"
                                        data-id="{{ $product->id }}"><span class="fa fa-trash"></span></button></td>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>

                        </tfoot>

                    </table>
                    <div class="row">
                        <div class="col-md-5 offset-md-6">
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">@lang('site.total') : </label>
                                <input type="number" name="total" class="form-control  col-sm-6 total-price" min="0"
                                    readonly value="{{ $sale->total }}">
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">@lang('site.discount') : </label>
                                <input type="number" id="discount" name="discount"
                                    class="form-control col-sm-6 discount" min="0" value="{{ $sale->discount }}">
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">@lang('site.totalamount') : </label>
                                <input type="number" id="total-amount" name="total_amount"
                                    class="form-control col-sm-6 total-amount" readonly min="0"
                                    value="{{ $sale->total_amount }}">
                            </div>
                            <div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">@lang('site.paymenttype') : </label>
                                    <select id="select" class="form-control col-sm-6" name="status">
                                        <option value="paid">@lang('site.paid')</option>
                                        <option value="nopaid">@lang('site.nopaid')</option>
                                        <option value="debt">@lang('site.due')</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">@lang('site.paid') : </label>
                                    <input id="paid" type="number" name="paid" class="form-control col-sm-6 paid"
                                        value="{{ $sale->paid }}"></input>
                                </div>
                            </div>
                            <div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">@lang('site.due') : </label>
                                    <input id="credit" type="number" name="credit" class="form-control col-sm-6 credit"
                                        readonly value="{{ $sale->due }}"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer form-group">
                        <button type="submit" class="btn btn-success" href="{{ route('sale.update', $sale->id) }}"><i
                                class="fas fa-user-plus"></i>
                            @lang('site.update')</button>
                    </div>
                </div>
            </form>
            <div class="modal fade bd-example-modal-lg-client" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">@lang('site.createclient')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="new_client" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            @include('partials._errors')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('site.clientname')</label>
                                            <input type="text" name="client_name" id="" class="form-control"
                                                value="{{ old('client_name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('site.phone')</label>
                                            <input type="text" name="phone" id="" class="form-control"
                                                value="{{ old('phone') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('site.address')</label>
                                            <textarea type="text" name="address" id=""
                                                class="form-control">{{ old('address') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('site.description')</label>
                                            <textarea type="text" name="description" id=""
                                                class="form-control">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('site.numeroregistrecommerce')</label>
                                            <input type="text" name="rc" id="" class="form-control"
                                                value="{{ old('rc') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('site.numeroarticle')</label>
                                            <input type="number" name="article" id="" class="form-control"
                                                value="{{ old('article') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('site.nif')</label>
                                            <input type="number" name="nif" id="" class="form-control"
                                                value="{{ old('nif') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('site.nis')</label>
                                            <input type="number" name="nis" id="" class="form-control"
                                                value="{{ old('nis') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">@lang('site.close')</button>
                                <button type="submit" class="btn btn-primary">@lang('site.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.card-body -->
</div>
<div class="col-md-6">
    <div class="card card-primary card-outline" style="height:80vh;">
        <div class="card-header">
            <h3 class="card-title">@lang('site.allproduct')</h3>
        </div> <!-- /.card-body -->
        <div class="card-body" style="overflow-y:scroll;">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">@lang('site.addproducttosalewithbarcode')</label>
                        <input id="addbarcode" class="form-control" type="text" name="addbarcode"
                            placeholder="@lang('site.scanbarcode')" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">@lang('site.searchforproductbynameorcategory')</label>
                        <input id="searchsale" class="form-control" type="text" name="searchproduct"
                            placeholder="@lang('site.searchforproduct')" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                @if ($products->count() > 0)
                <div id="pds" class="row text-center text-lg-left containerItems">

                    @foreach ($products as $product)

                    <div class="col-md-2 col-md-offset-1" style="margin:0;">
                        <a href="" data-tooltip="tooltip"
                            title="Price : {{ $product->sale_price }} stock : {{ $product->stock }}"
                            data-placement="top" id="product-{{ $product->id }}" +
                            data-name="{{ $product->product_name }}" + data-id="{{ $product->id }}" +
                            data-price="{{ $product->sale_price }}" + data-stock="{{ $product->stock }}" class="con d-block mb-4
                                add-product-btn">
                            <img class="img-fluid" src="{{ $product -> image_path }}" alt="">
                            <span class="mbr-gallery-title text-truncate">{{ $product->product_name }}</span>
                        </a>

                    </div>
                    @endforeach

                </div>
                @else
                <div class="lam">
                    <div class="centered">
                        <h5>@lang('site.thereisnoproductforsale')</h5>
                    </div>
                </div>


                @endif
            </div>
        </div><!-- /.card-body -->
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('body').tooltip({
            selector: "[data-tooltip=tooltip]",
            container: "body"
        });
        // add new client in sale page
        $('body').on('submit', '#new_client', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ \LaravelLocalization::localizeURL('/client') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (reponse) {
                    console.log(reponse);
                    $('.bd-example-modal-lg-client').modal('hide');
                    $('#new_client')[0].reset();
                    $("#client").load(" #client");

                },
                error: function (error) {
                    const errors = error.responseJSON.errors
                    const firstitem = Object.keys(errors)[0]
                    const firstitemDOM = document.getElementById(firstitem)
                    const firstErrorMessage = errors[firstitem][0]
                    firstitemDOM.scrollIntoView({})

                    const errorMessages = document.querySelectorAll('.text-danger')
                    errorMessages.forEach((element) => element.textContent = '')

                    firstitemDOM.insertAdjacentHTML('afterend',
                        `<div class="text-danger">${firstErrorMessage}</div>`)

                    const formControls = document.querySelectorAll('.form-control')
                    formControls.forEach((element) => element.classList.remove('border',
                        'border-danger'))

                    firstitemDOM.classList.add('border', 'border-danger')
                }
            });
        });
        // Search for product to sale by product name
        //let old_content = $('#pds').html();
        $("#searchsale").keyup(function () {
            var pro = $("#searchsale").val();
            // if (pro != '') {
            $.ajax({
                type: "GET",
                url: "/searchsale",
                data: 'pro=' + pro,
                dataType: 'json',
                success: function (data) {
                    $('#pds').html(data.row_result);
                    $('[data-tooltip="tooltip"]').tooltip();
                    console.log(data)

                }
            });
            // } else {
            //     $('#pds').html(old_content);
            // }
        });

        // Add product to sale by barcode
        $("#addbarcode").keypress(function () {
            var code = $("#addbarcode").val();
            if (code.length == 13) {
                $.ajax({
                    type: "GET",
                    url: "/addproduct",
                    data: 'code=' + code,
                    dataType: 'json',
                    success: function (data) {
                        $('.order-list').append(data.addproduct);
                        $("#addbarcode").val("");
                        calculateTotal();
                        calculateTotalAmount();
                        console.log(data.addproduct)

                    }
                });
            }
        });




    });

</script>


@endsection
