<table>
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Contact Number</th>
            <th>User Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <td>{{$client->client_fullname}}</td>
            <td>{{$client->contactNumber}}</td>
            <td>{{ucfirst(str_replace("_"," ", $client->user_type))}}</td>
        </tr>
        @endforeach
    </tbody>
</table>