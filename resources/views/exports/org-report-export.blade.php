<table>
    <thead>
        <tr>
            <th>Organization Name</th>
            <th>Date established</th>
            <th>Address</th>
            <th>Organizations' phone no.</th>
            <th>Representatives' name</th>
            <th>Representatives' position</th>
            <th>Representatives' phone no.</th>
            <th>No. of events joined</th>
        </tr>
    </thead>
    <tbody>
        @foreach($organizations as $org)
        <tr>
            <td>{{strtoupper($org->organization_name)}}</td>
            <td>{{$org->date_established}}</td>
            <td>{{$org->address}}</td>
            <td>{{$org->contact_number}}</td>
            <td>{{$org->representative_name}}</td>
            <td>{{$org->representative_position}}</td>
            <td>{{$org->representative_contact_number}}</td>
            <td>
                {{
                $a = App\Models\EventOrganizationsModel::where('id_organization', $org->org_id)->count()
                }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>