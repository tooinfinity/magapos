<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Facture | {{ $purchase->number_purchase }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.4/css/adminlte.min.css">
    <style>
        body {
            background-color: #ff
        }

        .padding {
            padding: 2rem !important
        }

        .card {
            margin-bottom: 30px;
            border: none;
            -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22)
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e6e6f2
        }

        h3 {
            font-size: 20px
        }

        h5 {
            font-size: 15px;
            line-height: 26px;
            color: #3d405c;
            margin: 0px 0px 15px 0px;
            font-family: 'Circular Std Medium'
        }

        .text-dark {
            color: #3d405c !important
        }

        .fix-footer {
            position: fixed;
            left: 0px;
            bottom: 0px;
            height: 35px;
            width: 100%;
            background: #1abc9c;
        }

        .head-dark {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }

        table.table-bordered {
            border: 2px solid #000000;
            border-radius: 10px;
        }

        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 2px solid #000000;
            border-radius: 10px;
        }

        .too-border {
            padding: 2px;
            border: 2px solid #000000;
            border-radius: 10px;
            margin: 5px 0;
        }

        .table th,
        .table td {
            padding: 0.25rem;
        }

        @media print {

            .table thead tr td,
            .table tbody tr td,
            .table thead tr th,
            .table tbody tr th {
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                -webkit-print-color-adjust: exact;
            }

            .col-print-1 {
                width: 8%;
                float: left;
            }

            .col-print-2 {
                width: 16%;
                float: left;
            }

            .col-print-3 {
                width: 25%;
                float: left;
            }

            .col-print-4 {
                width: 33%;
                float: left;
            }

            .col-print-5 {
                width: 42%;
                float: left;
            }

            .col-print-6 {
                width: 50%;
                float: left;
            }

            .col-print-7 {
                width: 58%;
                float: left;
            }

            .col-print-8 {
                width: 66%;
                float: left;
            }

            .col-print-9 {
                width: 75%;
                float: left;
            }

            .col-print-10 {
                width: 83%;
                float: left;
            }

            .col-print-11 {
                width: 92%;
                float: left;
            }

            .col-print-12 {
                width: 100%;
                float: left;
            }

            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .too-footer {
                position: absolute;
                bottom: 0;
            }
        }

    </style>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="card">
            <div class="card-header p-4" style="border: 2px solid #000000;border-radius: 10px;">
                <img src="{{ asset('/uploads/settings/'.$logo) }}" style="width:200px;" alt="" srcset="">
                <div class="float-right text-center">
                    <h3 class="mb-0">{{ $activity }}</h3>
                    Address : {{ $address }} <br>Phone : {{ $phone }} <br> N°
                    Registre Commerce
                    : {{ $rc }}<br>N°Article : {{ $article }}<br>NIF : {{ $nif }}<br>NIS :
                    {{ $nis }}
                </div>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="text-center too-border">
                    <h4>Facture : {{ $purchase->number_purchase }}</h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-print-6 text-center">
                        <div class="too-border">
                            <h4> Date: <span
                                    style="font-size:15px">{{ date_format($purchase->created_at,"d/m/Y") }}</span>
                            </h4>

                            <h4>Votre Commercial : <span style="font-size:15px">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}</span> </h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-print-6 text-center">
                        <div class="too-border">
                            <h4>provider Information</h4>
                        </div>
                        <div class="too-border">
                            provider Name : {{ $provider_purchases->provider_name }}<br>Address :
                            {{ $provider_purchases->address }}
                            <br>Phone : {{ $provider_purchases->phone }} <br> N° Registre Commerce :
                            {{ $provider_purchases->rc }}<br>N°Article : {{ $provider_purchases->article }}<br>NIF :
                            {{ $provider_purchases->nif }}<br>NIS : {{ $provider_purchases->nis }}
                        </div>
                    </div>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-bordered" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">N°</th>
                                <th style="width: 500px;">Product</th>
                                <th style="width: 100px;text-align:center;">Price unitaire</th>
                                <th style="width: 100px;text-align:center;">Quntite</th>
                                <th style="width: 100px;text-align:center;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_purchases as $product_purchase )
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $product_purchase->product_name }}</td>
                                <td style="text-align:center;">
                                    ${{ number_format($product_purchase->purchase_price, 2) }}
                                </td>
                                <td style="text-align:center;">{{ $product_purchase->pivot->quantity }}</td>
                                <td style="text-align:center;">
                                    ${{ number_format($product_purchase->pivot->quantity * $product_purchase->purchase_price, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right text-center" style="width:12%">
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>{{ number_format($purchase->total,2) }}</strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>{{ number_format($purchase->discount,2) }}</strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>{{ number_format($purchase->total_amount,2) }}</strong>
                            </p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>{{ number_format($purchase->paid,2) }}</strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;">
                                <strong>{{ number_format($purchase->total_amount - $purchase->paid,2) }}</strong></p>
                        </div>
                    </div>
                    <div class="float-right text-center" style="width:12%">
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Subtotal </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Discount </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Total amount </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Versment </strong></p>
                        </div>
                        <div style=" border: 2px solid #000000;border-radius: 10px;margin: 5px 0;">
                            <p style="margin-bottom:0;"><strong>Rest a payer </strong></p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="too-footer offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="too-border text-center">
            <p class="mb-0">{{ $activity }} {{ $store_name }} {{ $purchase->created_at }} Designed by TouwfiQ Meghlaoui
            </p>
        </div>
    </div>
    {{--  <script type="text/javascript">
        window.addEventListener("load", window.print());

    </script>  --}}
</body>

</html>
