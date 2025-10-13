<!DOCTYPE html>
<html>

<head>
    <title>Laporan Rekap Pengaduan TTE</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            font-weight: bold;
            color: #2c3e50;
        }

        .summary {
            margin-top: 10px;
            font-weight: bold;
            color: #c0392b;
        }
    </style>
</head>

<body>
    <h2>Laporan Rekapitulasi Pengaduan Tanda Tangan Elektronik (TTE)</h2>

    <div class="summary">
        Total Aduan: {{ $total }} |
        Belum Selesai: {{ $totalPending }} |
        Sudah Selesai: {{ $totalSelesai }}
    </div>

    @php
        // Ambil semua kategori dari database (supaya muncul walaupun 0)
        $allKategori = \App\Models\Kategori::pluck('nama_kategori')->unique()->filter()->values();
    @endphp

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">OPD</th>
                @foreach ($allKategori as $kategori)
                    <th colspan="2">{{ $kategori }}</th>
                @endforeach
                <th rowspan="2">Total</th>
            </tr>
            <tr>
                @foreach ($allKategori as $kategori)
                    <th>Pending</th>
                    <th>Selesai</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapPerOpd as $opd => $dataOpd)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $opd ?? 'Tidak Ada OPD' }}</td>

                    @foreach ($allKategori as $kategori)
                        @php
                            $dataKategori = $dataOpd->where('kategori.nama_kategori', $kategori);
                            $pending = $dataKategori->where('status', 'pending')->count();
                            $selesai = $dataKategori->where('status', 'selesai')->count();
                        @endphp
                        <td>{{ $pending }}</td>
                        <td>{{ $selesai }}</td>
                    @endforeach

                    <td>{{ $dataOpd->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
