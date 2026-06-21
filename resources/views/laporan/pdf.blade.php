<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kinerja</title>

    <style>

        body{
            font-family: Arial, sans-serif;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid black;
            padding:8px;
        }

        th{
            background:#f2f2f2;
        }

    </style>

</head>
<body>

<h2 align="center">
    LAPORAN KINERJA PEGAWAI
</h2>

<table>

    <tr>
        <th>No</th>
        <th>Pegawai</th>
        <th>Nilai</th>
        <th>Catatan</th>
    </tr>

    @foreach($evaluasis as $evaluasi)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>
            {{ $evaluasi->nama_pegawai }}
        </td>

        <td>
            {{ $evaluasi->nilai }}
        </td>

        <td>
            {{ $evaluasi->catatan }}
        </td>

    </tr>

    @endforeach

</table>

</body>
</html>