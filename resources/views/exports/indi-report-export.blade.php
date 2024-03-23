<table>
    <thead>
        <tr>
            <th>Riders Name</th>
            <th>No. of events joined</th>
            <th>No. of clients served</th>
        </tr>
    </thead>
    <tbody>
        @foreach($riders as $item)
        <tr>
            <td>{{ucfirst($item->rider_fullname)}}</td>
            <td>
                @php
                $a = App\Models\EventOrganizationRidersModel::where('id_individual', $item->id)->pluck('id');
                echo $a->count();
                @endphp
            </td>
            <td>
                @php
                $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->pluck('id');
                echo $b->count();
                @endphp
            </td>
        </tr>
        @endforeach
    </tbody>
</table>