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
            margin-right: 50px;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <table class="w-full">
        <tr>
            <!-- <td>
                <img src="data:image/png;base64,{{ $city_logo }}" alt="city-logo" width="85" style="margin-right: 100px;" />

                <img src="data:image/png;base64,{{ $bls_logo }}" alt="bls-log" width="300" style="margin-right: 55px;" />

                <img src="data:image/png;base64,{{ $rise_logo }}" alt="rise-logo" width="150" />
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
                <td class="w-half">
                    <div>
                        <h4>Event: <span style="font-weight: lighter;">{{empty($query_event->event_name) ? 'ALL' : ucfirst($query_event->event_name)}}</span></h4>
                    </div>
                    <!-- <div>{{empty($start_date) ? 'ALL' : date('M-d-Y', strtotime($start_date))}} {{ empty($end_date) ? ' ' : ' to ' }} {{empty($end_date) ? ' ' : date('M-d-Y', strtotime($end_date))}}</div> -->
                </td>
                <td class="w-half">
                    <div>
                        <h4>Date: <span style="font-weight: lighter;">{{empty($start_date) ? (empty($query_event->event_date) ? 'ALL' : date('M-d-Y', strtotime($query_event->event_date))) : date('M-d-Y', strtotime($start_date))}} {{ empty($end_date) ? ' ' : ' to ' }} {{empty($end_date) ? ' ' : date('M-d-Y', strtotime($end_date))}}</span></h4>
                    </div>
                    <!-- <div>{{empty($start_date) ? 'ALL' : date('M-d-Y', strtotime($start_date))}} {{ empty($end_date) ? ' ' : ' to ' }} {{empty($end_date) ? ' ' : date('M-d-Y', strtotime($end_date))}}</div> -->
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Organziation</th>
                <th>Event</th>
                <th style="font-size: 7px;">Total no. <br>of client served</th>
                <th>Date</th>
                <th>Location</th>
            </tr>
            @foreach($event_organization as $item)
            <tr class="items">

                <td>{{$item->organization_name}}</td>
                <td>{{$item->event_name}}</td>
                <td style="text-align: center;">
                    @php
                    $a = App\Models\EventOrganizationRidersModel::where('id_event_organization', $item->id)->pluck('id');
                    $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->count();
                    echo $b;
                    @endphp
                </td>
                <td>{{$item->event_date}}</td>
                <td>{{ucfirst($item->event_location)}}</td>

            </tr>
            @endforeach
        </table>
    </div>

    <div class="total">
        Total: {{$event_organization->count()}}
    </div>

    <div class="footer margin-top">
        <!-- <div>--END--</div> -->
        <div>&copy; Bayanihan Libreng Sakay</div>
    </div>
</body>

</html>