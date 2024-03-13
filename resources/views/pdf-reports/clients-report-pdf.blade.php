<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>report-pdf</title>
    <style>
        body {
            font-family: DejaVu Sans;
        }

        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: rgb(10, 52, 94);
        }

        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
        }

        table tr.items td {
            padding: 0.5rem;
        }

        table th {
            text-align: left;
            text-transform: uppercase;
        }

        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <table class="w-full">
        <tr>
            <td style="text-align: center;">
                <img src="data:image/png;base64,{{ $bls_logo }}" alt="laravel daily" width="300" />
            </td>
            <!-- <td class="w-half">
                <h2>Report</h2>
            </td> -->
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div>
                        <h4>Date:</h4>
                    </div>
                    <div>{{empty($start_date) ? 'ALL' : date('M-d-Y', strtotime($start_date))}} {{ empty($end_date) ? ' ' : ' to ' }} {{empty($end_date) ? ' ' : date('M-d-Y', strtotime($end_date))}}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Client</th>
                <th>Contact Number</th>
                <th>User Type</th>
            </tr>
            @foreach($clients as $item)
            <tr class="items">

                <td>
                    {{ $item['client_fullname'] }}
                </td>
                <td>
                    {{ $item['contactNumber'] }}
                </td>
                <td>
                    {{ ucfirst(str_replace("_"," ", $item['user_type'])) }}
                </td>

            </tr>
            @endforeach
        </table>
    </div>

    <div class="total">
        Total: {{$clients->count()}}
    </div>

    <div class="footer margin-top">
        <div>--END--</div>
        <div>&copy; Bayanihan Libreng Sakay</div>
    </div>
</body>

</html>