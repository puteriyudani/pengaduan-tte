<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Pengaduan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 5px 0;
            padding: 0;
        }

        h4,
        h5 {
            text-align: justify;
            margin: 5px 0;
            padding: 0;
        }

        .page-break {
            page-break-before: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        .summary {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Laporan Data Pengaduan</h2>

    @foreach ($pengaduanPerOpd as $opd => $dataOpd)
        <div class="{{ !$loop->first ? 'page-break' : '' }}">
            <h3>OPD: {{ $opd ?? 'Tidak Ada OPD' }}</h3>

            {{-- Group per kategori --}}
            @foreach ($dataOpd->groupBy('kategori.nama_kategori') as $kategori => $dataKategori)
                <h4>Kategori: {{ $kategori ?? 'Tanpa Kategori' }}</h4>

                {{-- Group per bulan --}}
                @foreach ($dataKategori->groupBy(function ($item) {
        return $item->created_at->format('F Y'); // contoh: Januari 2025
    }) as $bulan => $dataBulan)
                    <h5>Bulan: {{ $bulan }}</h5>

                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. WhatsApp</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataBulan as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->whatsapp }}</td>
                                    <td>{{ $p->keterangan }}</td>
                                    <td>{{ $p->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="summary">
                        Jumlah pengaduan bulan {{ $bulan }}: {{ $dataBulan->count() }}
                    </div>
                @endforeach
            @endforeach

            <div class="summary">
                Jumlah pengaduan di OPD {{ $opd }}: {{ $dataOpd->count() }}
            </div>
        </div>
    @endforeach

</body>

</html>
