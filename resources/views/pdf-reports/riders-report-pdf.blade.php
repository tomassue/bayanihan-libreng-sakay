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

        .third {
            font-size: 8px !important;
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
                <td class="w-half">
                    <div>
                        <h4>Date: <span style="font-weight: lighter;">{{empty($start_date) ? 'ALL' : date('M-d-Y', strtotime($start_date))}} {{ empty($end_date) ? ' ' : ' to ' }} {{empty($end_date) ? ' ' : date('M-d-Y', strtotime($end_date))}}</span></h4>
                    </div>
                    <!-- <div>{{empty($start_date) ? 'ALL' : date('M-d-Y', strtotime($start_date))}} {{ empty($end_date) ? ' ' : ' to ' }} {{empty($end_date) ? ' ' : date('M-d-Y', strtotime($end_date))}}</div> -->
                </td>
                <td class="w-half">
                    <div>
                        <h4>Organization:
                            <span style="font-weight: lighter;">
                                @php
                                $org = App\Models\OrganizationInformationModel::where('id', $query_org)
                                ->select('organization_name')
                                ->first();

                                echo empty($query_org) ? 'ALL' : ucfirst($org->organization_name);
                                @endphp
                            </span>
                        </h4>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Rider</th>
                <th>Organization</th>
                <th width="100px" class="third">Total no. of events joined</th>
                <th width="100px" class="third">Total no. of <br> clients served</th>
            </tr>
            @foreach($riders as $item)
            <tr class="items">

                <td>
                    {{ $item['rider_fullname'] }}
                </td>
                <td>
                    {{ $item['organization'] }}
                </td>
                <td style="text-align: center;">
                    @php
                    echo $c = App\Models\EventOrganizationRidersModel::where('id_individual', $item['id'])->get()->count();
                    @endphp
                </td>
                <td style="text-align: center;">
                    @php
                    $a = App\Models\EventOrganizationRidersModel::where('id_individual', $item['id'])->pluck('id');
                    echo $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->count();
                    @endphp
                </td>

            </tr>
            @endforeach
        </table>
    </div>

    <div class="total">
        Total: {{$riders->count()}}
    </div>

    <div class="footer margin-top">
        <!-- <div>--END--</div> -->
        <div>&copy; Bayanihan Libreng Sakay</div>
    </div>
</body>

</html>