<table>
    <thead>
        <tr>
            <th>CLIENT'S NAME</th>
            <th>ADDRESS</th>
            <th>CONTACT NUMBER</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <td>{{ $client->last_name . ', ' . $client->first_name . ($client->middle_name ? ' ' . $client->middle_name : '') . ($client->ext_name ? ' ' . $client->ext_name . '.' : '') }}</td>
            <td>{{ $client->address }}</td>
            <td>{{ $client->contact_number }}</td>
        </tr>
        @endforeach
    </tbody>
</table>