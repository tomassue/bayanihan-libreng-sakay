<table>
    <thead>
        <tr>
            <th>Riders' Name</th>
            <th>Organization</th>
            <th>Total no. of events joined</th>
            <th>Total no. of clients served</th>
        </tr>
    </thead>
    <tbody>
        @foreach($riders as $rider)
        <tr>
            <td>{{$rider->rider_fullname}}</td>
            <td>{{$rider->organization}}</td>
            <td>
                @php
                echo $c = App\Models\EventOrganizationRidersModel::where('id_individual', $rider['id'])->get()->count();
                @endphp
            </td>
            <td>
                @php
                $a = App\Models\EventOrganizationRidersModel::where('id_individual', $rider->id)->pluck('id');
                echo $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->count();
                @endphp
            </td>
        </tr>
        @endforeach
    </tbody>
</table>