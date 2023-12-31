<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tahun Akademik</th>
            <th>Kode</th>
            <th>Matkul</th>
            <th>SKS</th>
            <th>Kelas</th>
            <th>Angkatan</th>
            <th>Hari / Waktu / Ruang</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1 @endphp
        @foreach($schedules as $schedule)
        @foreach($schedule->detail as $row)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $schedule->user->nip }}</td>
            <td>{{ $schedule->user->name }}</td>
            <td>{{ $schedule->user->email }}</td>
            <td>{{ $schedule->academic_year }} {{ $schedule->type_periode }}</td>
            <td>{{ $row->code }} ({{ $row->matkul->code }})</td>
            <td>{{ $row->matkul->name }}</td>
            <td>{{ $row->sks }}</td>
            <td>{{ $row->class->name }}</td>
            <td>{{ $row->class->angkatan }}</td>
            <td>{{ $row->day }} / {{ date('H:i', strtotime($row->start_time)) }} s.d {{ date('H:i', strtotime($row->end_time)) }} / {{ $row->room }}</td>
        </tr>
        @php $i += 1 @endphp
        @endforeach
        @endforeach
    </tbody>
</table>