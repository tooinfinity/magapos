@extends('layouts.main')

@section('page')
@lang('site.spending')
@endsection


@section('content')
@include('sweetalert::alert')
{{-- spending row  --}}
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header with-border">
            <div class="row">
                <h3 class="card-title">@lang('site.spendings')</h3>
                {{--  create new spending  --}}
                <button class="btn btn-success ml-auto" data-toggle="modal"
                    data-target=".newspend">@lang('site.createspending')</button>
                <div class="modal fade newspend" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="exampleModalLongTitle">
                                    @lang('site.createspending')
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="new_spend">
                                @csrf
                                @method('post')
                                @include('partials._errors')
                                <div class="modal-body">
                                    <div class="col-md-8 text-dark">
                                        <div class="form-group row">
                                            <label class="col-sm-6 col-form-label">@lang('site.spendingname')</label>
                                            <input type="text" name="spending_name" class="form-control col-sm-6">
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-6 col-form-label">@lang('site.description')</label>
                                            <textarea name="spending_description"
                                                class="form-control col-sm-6 "></textarea>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-6 col-form-label">@lang('site.spendingprice')</label>
                                            <input type="number" name="spending_price" class="form-control col-sm-6">
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
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div id="spending_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="spending_table" class="table table-bordered table-striped table-hover  dataTable"
                            role="grid" aria-describedby="spending_table_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Rendering engine: activate to sort column descending"
                                        style="width: 283px;">No</th>
                                    <th style="display:none;"></th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending"
                                        style="width: 359px;">@lang('site.spendingname')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                        style="width: 320px;">@lang('site.description')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                        style="width: 320px;">@lang('site.spendingprice')</th>
                                    <th class="sorting" tabindex="0" aria-controls="category_table" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 243px;">@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($spendings as $index => $spending)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td style="display:none;">{{ $spending->id }}</td>
                                    <td>{{ $spending->spending_name }}</td>
                                    <td>{{ $spending->spending_description }}</td>
                                    <td>{{ $spending->spending_price }}</td>
                                    <td>
                                        @if (auth()->user()->hasPermission('update_spendings'))
                                        <button class="btn btn-warning btn-sm editspend"><i
                                                class="fas fa-edit"></i>@lang('site.edit')</button>
                                        @else
                                        <a class="btn btn-warning btn-sm disabled"><i
                                                class="fas fa-edit"></i>@lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission('delete_spendings'))
                                        <button id="delete" onclick="deletemoderator({{ $spending->id }})"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                            @lang('site.delete')</button>
                                        <form id="form-delete-{{ $spending->id }}"
                                            action="{{ route('spending.destroy', $spending->id) }}" method="post"
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
                                    <th style="display:none;"></th>
                                    <th rowspan="1" colspan="1">@lang('site.spendingname')</th>
                                    <th rowspan="1" colspan="1">@lang('site.description')</th>
                                    <th rowspan="1" colspan="1">@lang('site.spendingprice')</th>
                                    <th rowspan="1" colspan="1">@lang('site.action')</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- update spending    --}}
            <div class="modal fade" id="updatespend" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="exampleModalLongTitle">
                                @lang('site.editspending')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="update_spend">
                            @csrf
                            @method('put')
                            @include('partials._errors')
                            <div class="modal-body">
                                <div class="col-md-8 text-dark">
                                    <input type="hidden" id="idspend" name="idspend">
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">@lang('site.spendingname')</label>
                                        <input type="text" id="spending_name" name="spending_name"
                                            class="form-control col-sm-6">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">@lang('site.description')</label>
                                        <textarea name="spending_description" id="spending_description"
                                            class="form-control col-sm-6"></textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label">@lang('site.spendingprice')</label>
                                        <input type="number" id="spending_price" name="spending_price"
                                            class="form-control col-sm-6">
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
        <!-- /.card-body -->


    </div>
    <div class="card card-primary">
        <div class="card-header with-border">
            <div class="row">
                <h3 class="card-title">@lang('site.totalspendingmoney')</h3>
                <div class="ml-auto">
                    <input type="number" readonly class="form-control text-center" value="{{ $totalspendings }}">
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        jQuery.noConflict();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // add new spending ajax request
        $('#new_spend').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ \LaravelLocalization::localizeURL('/newspend') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (reponse) {
                    console.log(reponse)
                    $('.newspend').modal('hide')
                    // refresh only datatable
                    //$('#spending_table').datatable().ajax.reload();
                    location.reload();

                },
                error: function (error) {
                    console.log(error)
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

        // update spending with ajax request
        $('.editspend').on('click', function () {
            $('#updatespend').modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();
            console.log(data);
            $('#idspend').val(data[1]);
            $('#spending_name').val(data[2]);
            $('textarea#spending_description').val(data[3]);
            $('#spending_price').val(data[4]);
        });

        $('#update_spend').on('submit', function (e) {
            e.preventDefault();

            var id = $('#idspend').val();

            $.ajax({
                type: 'PUT',
                url: "/updatespend/" + id,
                data: $('#update_spend').serialize(),
                success: function (data) {
                    console.log(data);
                    $('#updatespend').modal('hide');
                    // refresh only datatable
                    //$('#spending_table').datatable().ajax.reload();
                    location.reload();

                },
                error: function (error) {
                    console.log(error)
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

    });

</script>
@endsection
