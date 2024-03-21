<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Rider</th>
        </tr>
    </thead>
    <tbody>
        @php $no=1; @endphp
        @foreach($attendance as $item)
        <tr>
            <td>{{$no}}</td>
            <td>{{$item->rider_fullname}}</td>
        </tr>
        @php $no++ @endphp
        @endforeach
    </tbody>
</table>