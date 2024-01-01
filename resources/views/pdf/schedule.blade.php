<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .title h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .title h2 {
            font-size: 16px;
            margin: 0;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 0;
            line-height: 1.5;
            display: flex;
            justify-content: space-between;
        }

        .info strong {
            width: 120px;
            margin-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
            /* Adjust the font size as needed */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            /* Adjust the padding as needed */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="title">
            <h1>Jadwal Perkuliahan</h1>
            <h2>Tahun Akademik {{ $schedule->academic_year }} {{ $schedule->type_periode }}</h2>
        </div>

        <div class="info">
            <p><strong>Nama:</strong> {{ $schedule->user->name }}</p>
            <p><strong>NIP:</strong> {{ $schedule->user->nip }}</p>
            <p><strong>Tahun Akademik:</strong> {{ $schedule->academic_year }} {{ $schedule->type_periode }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Matkul</th>
                    <th>SKS</th>
                    <th>Kelas</th>
                    <th>Angkatan</th>
                    <th>Hari / Waktu / Ruang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedule->detail as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->code }} ({{ $row->matkul->code }})</td>
                    <td>{{ $row->matkul->name }}</td>
                    <td>{{ $row->sks }}</td>
                    <td>{{ $row->class->name }}</td>
                    <td>{{ $row->class->angkatan }}</td>
                    <td>{{ $row->day }} / {{ date('H:i', strtotime($row->start_time)) }} s.d {{ date('H:i', strtotime($row->end_time)) }} / {{ $row->room }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>