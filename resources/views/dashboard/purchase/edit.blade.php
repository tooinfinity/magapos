@extends('layouts.pos')


@section('content')

<div class="col-md-6">
    <div class="card card-primary card-outline" style="height:80vh;">
        <div class="card-header">
            <h3 class="card-title">@lang('site.productspurchase')</h3>

        </div> <!-- /.card-body -->
        <div class="card-body" style="overflow-y:scroll;">
            <form action="{{ route('purchase.update', $purchase->id) }}" method="post">

                @csrf
                @method('put')

                @include('partials._errors')
                <div class="row">
                    <div class="col-md-6">
                        <div id="provider" class="form-group">
                            <label for="">@lang('site.selectprovider')</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="provider_id" class="form-control">
                                        @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}"
                                            {{ $providersel->id == $provider->id ? 'selected' : ''}}>{{
                                    $provider->provider_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target=".bd-example-modal-lg-provider">@lang('site.addprovider')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.numberpurchase') : </label>
                            <input type="text" name="number_purchase" class="form-control text-center" readonly
                                value="{{ $purchase->number_purchase }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <table id="purchase" class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('site.productname')</th>
                                <th>@lang('site.quantitypurchase')</th>
                                <th>@lang('site.purchaseprice')</th>
                                <th style="width: 25px;">@lang('site.delete')</th>
                            </tr>
                        </thead>

                        <tbody class="order-list">
                            @foreach ($purchase->products as $product)
                            <tr id="{{ $product->id }}" class="form-group items">
                                <td id="name" class="namex">{{ $product->product_name }}</td>
                                <input type="hidden" name="product[]" value="{{ $product->id }}">
                                <td style="display: flex;">
                                    <input id="qty" style="width: 60% !important;" type="number" name="quantity[]"
                                        data-price="{{ $product->purchase_price }}" data-stock="{{ $product->stock }}"
                                        class="form-control input-sm product-quantity" min="1"
                                        max="{{ $product->stock }}" value="{{ $product->pivot->quantity }}">
                                </td>
                                <td class="product-price">{{ $product->purchase_price * $product->pivot->quantity }}
                                </td>
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
                                    readonly value="{{ $purchase->total }}">
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">@lang('site.discount') : </label>
                                <input type="number" id="discount" name="discount"
                                    class="form-control col-sm-6 discount" min="0" value="{{ $purchase->discount }}">
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">@lang('site.totalamount') : </label>
                                <input type="number" id="total-amount" name="total_amount"
                                    class="form-control col-sm-6 total-amount" readonly min="0"
                                    value="{{ $purchase->total_amount }}">
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
                                        value="{{ $purchase->paid }}"></input>
                                </div>
                            </div>
                            <div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">@lang('site.due') : </label>
                                    <input id="credit" type="number" name="credit" class="form-control col-sm-6 credit"
                                        readonly value="{{ $purchase->due }}"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer form-group">
                        <button type="submit" class="btn btn-success"
                            href="{{ route('purchase.update', $purchase->id) }}"><i class="fas fa-user-plus"></i>
                            @lang('site.update')</button>
                    </div>
                </div>
            </form>
            <div class="modal fade bd-example-modal-lg-provider" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">@lang('site.createprovider')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="new_provider" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            @include('partials._errors')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('site.providername')</label>
                                            <input type="text" name="provider_name" id="" class="form-control"
                                                value="{{ old('provider_name') }}">
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
                        <label for="">@lang('site.addproducttopurchasewithbarcode')</label>
                        <input id="addbarcode" class="form-control" type="text" name="addbarcode"
                            placeholder="@lang('site.scanbarcode')" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">@lang('site.searchforproductbynameorcategory')</label>
                        <input id="searchpurchase" class="form-control" type="text" name="searchproduct"
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
                            title="Price : {{ $product->purchase_price }} stock : {{ $product->stock }}"
                            data-placement="top" id="product-{{ $product->id }}" +
                            data-name="{{ $product->product_name }}" + data-id="{{ $product->id }}" +
                            data-price="{{ $product->purchase_price }}" + data-stock="{{ $product->stock }}" class="con d-block mb-4
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
                        <h5>@lang('site.thereisnoproductforpurchase')</h5>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // add new product in purchase page
        $('body').on('submit', '#new_product', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ \LaravelLocalization::localizeURL('/product') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (reponse) {
                    //alert(reponse)
                    //console.log(reponse)
                    $('.bd-example-modal-lg').modal('hide')
                    $('#new_product')[0].reset();
                    //$("#pds").load(" #pds");
                    $("#pronew").load(" #pronew > *");
                    $('[data-tooltip="tooltip"]').tooltip();
                    // $("#proscroll").animate({
                    //     scrollTop: $(document).height()
                    // }, 'slow');

                    //alert("data saved");
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
                    //console.log(firstitem)

                    //alert("data not saved");
                }
            });
        });
        // add new provider in purchase page
        $('body').on('submit', '#new_provider', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ \LaravelLocalization::localizeURL('/provider') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (reponse) {
                    console.log(reponse);
                    $('.bd-example-modal-lg-provider').modal('hide');
                    $('#new_provider')[0].reset();
                    $("#provider").load(" #provider");

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
        // Search for product to purchase by product name
        let old_content = $('#pds').html();
        $("#searchpurchase").keyup(function () {
            var pro = $("#searchpurchase").val();
            // if (pro != '') {
            $.ajax({
                type: "GET",
                url: "/searchpurchase",
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
        // Update product prices
        /*
        1 = Left mouse button
        2 = Centre mouse button
        3 = Right mouse button
        */
        $('body').on('click', '#update_product_price_button', function (e) {

            /* Right mouse button was clicked! */
            $('#modal-update-price').on('show.bs.modal', function (
                event) { // id of the modal with event
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                var purchase_price = button.data('price')
                var sale_price = button.data('sale')

                // Update the modal's content.
                var modal = $(this)
                modal.find('#id').val(id)
                modal.find('#purchase_price').val(purchase_price)
                modal.find('#sale_price').val(sale_price)


            });
            $('body').on('submit', '#update_product_price', function (e) {
                e.preventDefault();
                var id = $('#id').val();

                $.ajax({
                    type: 'PUT',
                    url: "{{ \LaravelLocalization::localizeURL('/updateprice') }}/" +
                        id,
                    data: $('#update_product_price').serialize(),
                    success: function (data) {
                        //console.log(data);
                        $('#modal-update-price').modal('hide');
                        $('#update_product_price')[0].reset();
                        //$("#pds").load(" #pds");
                        $("#pronew").load(" #pronew > *");
                        // refresh only datatable
                        //$('#spending_table').datatable().ajax.reload();
                        //location.reload();

                    },
                    error: function (error) {
                        console.log(error)
                        const errors = error.responseJSON.errors
                        const firstitem = Object.keys(errors)[0]
                        const firstitemDOM = document.getElementById(firstitem)
                        const firstErrorMessage = errors[firstitem][0]
                        firstitemDOM.scrollIntoView({})

                        const errorMessages = document.querySelectorAll(
                            '.text-danger')
                        errorMessages.forEach((element) => element.textContent =
                            '')

                        firstitemDOM.insertAdjacentHTML('afterend',
                            `<div class="text-danger">${firstErrorMessage}</div>`
                        )

                        const formControls = document.querySelectorAll(
                            '.form-control')
                        formControls.forEach((element) => element.classList
                            .remove('border',
                                'border-danger'))

                        firstitemDOM.classList.add('border', 'border-danger')
                    }
                });
            });
        });


        // Search for product to purchase by category id selected
        // not working perfectly i will fix it later
        /*$("#category").change(function () {
            var cat = $("#category").val();
            if (cat != '') {
                $.ajax({
                    type: "GET",
                    url: "/search",
                    data: 'cat=' + cat,
                    dataType: 'json',
                    success: function (data) {
                        $('#pds').html(data.row_result);
                        console.log(data)

                    }
                });
            } else {
                $('#pds').html(old_content);
            }
        });*/
    });

</script>

@endsection
