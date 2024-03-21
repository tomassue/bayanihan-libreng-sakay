<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>report-pdf</title>
    <style>
        html {
            font-size: x-small;
        }

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
            margin-right: 50px;
        }
    </style>
</head>

<body>
    <table class="w-full">
        <tr>
            <!-- <td style="text-align: center;">
                <img src="data:image/png;base64,{{ $bls_logo }}" alt="laravel daily" width="300" />
            </td> -->
            <!-- <td class="w-half">
                <h2>Report</h2>
            </td> -->
            <td style="text-align: left;">
                <img src="data:image/png;base64,{{ $city_logo }}" alt="city-logo" width="100" />
            </td>

            <td style="text-align: center;">
                <img src="data:image/png;base64,{{ $bls_logo }}" alt="bls-log" width="300" />
            </td>

            <td style="text-align: right;">
                <img src="data:image/png;base64,{{ $rise_logo }}" alt="rise-logo" width="150" />
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-full">
                    <div style="text-align: center; margin-bottom: 30px; text-transform: uppercase;">
                        <h1>ATTENDANCE FORM <br> <span style="font-size: small;">({{$org}})</span></h1>
                    </div>
                </td>
            </tr>
        </table>
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div>
                        <h4>Event: <span style="font-weight: lighter;">{{empty($event->event_name) ? 'ALL' : $event->event_name }}</span></h4>
                    </div>
                    <div>
                        <h4>Date: <span style="font-weight: lighter;">{{empty($event->events_date) ? 'ALL' : $event->events_date }}</span></h4>
                    </div>
                    <!-- <div>{{empty($start_date) ? 'ALL' : date('M-d-Y', strtotime($start_date))}} {{ empty($end_date) ? ' ' : ' to ' }} {{empty($end_date) ? ' ' : date('M-d-Y', strtotime($end_date))}}</div> -->
                </td>
                <td class="w-half">
                    <div>
                        <h4>Time: <span style="font-weight: lighter;">{{empty($event->events_time) ? 'ALL' : $event->events_time }}</span></h4>
                    </div>
                    <div>
                        <h4>Location: <span style="font-weight: lighter;">{{empty($event->event_location) ? 'ALL' : $event->event_location }}</span></h4>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <tr>
                <th>No</th>
                <th>Rider</th>
            </tr>

            @php $no=1; @endphp
            @foreach($attendance as $item)
            <tr class="items">
                <td width="90px">
                    {{ $no }}
                </td>
                <td>
                    {{ $item['rider_fullname'] }}
                </td>
            </tr>
            @php $no++ @endphp
            @endforeach

        </table>
    </div>

    <div class="total">
        Total: {{$attendance->count()}}
    </div>

    <div class="footer margin-top">
        <!-- <div>--END--</div> -->
        <div>&copy; Bayanihan Libreng Sakay</div>
    </div>
</body>

</html>