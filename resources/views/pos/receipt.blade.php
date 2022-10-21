@php
    $system = DB::table('settings')
        ->get()
        ->first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Receipt</title>
    <style>
        * {
            font-size: 12px;
            font-family: 'Times New Roman';
        }

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }

        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .left {
            text-align: left;
            align-content: left;
        }

        .right {
            text-align: right;
            align-content: right;
        }

        .ticket {
            width: 155px;
            max-width: 155px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <img src="{{ !empty($system->logo) ? asset('storage/' . $system->logo) : asset('/images/app-logo.svg') }}"
            alt="Logo">
        <p class="centered">{{ $system->business_name ?? null }}
            <br>{{ $system->address ?? null }}
            <br>{{ $system->contact ?? null }}
            <br>{{ $system->email ?? null }}
        </p>
        <hr>
        <p style="margin: 0">RECEIPT No: {{ $sales->id ?? null }}</p>
        <p style="margin: 0">Date: {{ date('m/d/Y h:i A', strtotime($sales->created_at)) }}</p>
        <p style="margin: 0">Served By: {{ $sales->username }}</p>
        <hr>
        <p style="margin: 0;font-weight:bold"> Purchase (total {{ number_format($sales->total_qty) }} item/s)</p>
        <table style="width: 100%; border: none; ">
            <tbody>
                @foreach ($sold_items as $row)
                    <tr>
                        <td class="description">
                            {{ $row->name }}
                            <br>{{ number_format($row->sale_qty) . ' x ' . number_format($row->sale_price, 2) }}
                        </td>
                        <td style="text-align: right">₱ {{ number_format($row->sale_qty * $row->sale_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr style="border-top: 1px dashed black">
        <table style="width: 100%">
            @php
                $vat = $sales->total_amount * ($system->vat / 100);
                $discount = $sales->total_amount * ($sales->discount / 100);
            @endphp
            <tbody>
                <tr>
                    <td colspan="2">Net VATable Sale:</td>
                    <td class="right">₱ {{ number_format($sales->total_amount - $vat, 2) ?? null }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">{{ $system->vat }}% VAT:</td>
                    <td class="right">₱ {{ number_format($vat, 2) ?? null }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Subtotal:</td>
                    <td class="right">₱ {{ number_format($sales->total_amount, 2) ?? null }}</td>
                </tr>
                <tr>
                    <td colspan="2">Discount({{ $sales->discount }}%):</td>
                    <td class="right">- ₱ {{ number_format($discount, 2) ?? null }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 14px; font-weight:bold">Total:</td>
                    <td class="right" style="font-size: 14px;font-weight:bold">₱
                        {{ number_format($sales->total_amount - $discount, 2) ?? null }}</td>
                </tr>
            </tbody>
        </table>
        <hr style="border-top: 1px dashed black">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td colspan="2">Payment Method:</td>
                    <td class="right">Cash</td>
                </tr>
                <tr>
                    <td colspan="2">Amount Tender:</td>
                    <td class="right">₱ {{ number_format($sales->cash, 2) ?? null }}</td>
                </tr>
                <tr>
                    <td colspan="2">Change:</td>
                    <td class="right">₱
                        {{ number_format($sales->cash - ($sales->total_amount - $discount), 2) ?? null }}</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div class="centered" style="width: 100px; margin-top:10px;">{!! DNS1D::getBarcodeHTML($sales->reference, 'PHARMA') !!}</div>
        <p class="centered" style="margin: 0;font-weight:bold">{{ $sales->reference }}</p>
        <p class="centered">Thank you and come again!</p>
    </div>
    <script>
        window.print();
        setTimeout(window.close, 2000);
    </script>
</body>

</html>
