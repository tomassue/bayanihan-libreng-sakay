<table>
    <thead>
        <tr>
            <th>Organization</th>
            <th>Event</th>
            <th>Total no. of client served</th>
            <th>Date</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
        @foreach($event_organization as $item)
        <tr>
            <td>{{$item->organization_name}}</td>
            <td>{{$item->event_name}}</td>
            <td>
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
    </tbody>
</table>