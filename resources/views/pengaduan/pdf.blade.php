<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Pengaduan TTE</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin: 10px 0;
            color: #2c3e50;
        }

        h3 {
            text-align: center;
            margin: 8px 0;
            color: #2980b9;
            /* biru untuk OPD */
        }

        h4 {
            margin: 6px 0;
            color: #27ae60;
            /* hijau untuk kategori */
        }

        h5 {
            margin: 4px 0;
            color: #8e44ad;
            /* ungu untuk bulan */
        }

        .page-break {
            page-break-before: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table,
        th,
        td {
            border: 1px solid #444;
            padding: 5px;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            color: #2c3e50;
            font-weight: bold;
        }

        td {
            vertical-align: top;
        }

        /* Status warna */
        .status-pending {
            color: #d35400;
            /* oranye */
            font-weight: bold;
        }

        .status-selesai {
            color: #27ae60;
            /* hijau */
            font-weight: bold;
        }

        .summary {
            margin-top: 8px;
            font-weight: bold;
            color: #c0392b;
            /* merah untuk total */
        }
    </style>
</head>

<body>
    <h2>Laporan Data Pengaduan Tanda Tangan Elektronik (TTE)</h2>

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
                                <th>Status</th>
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
                                    <td class="status-{{ $p->status }}">
                                        {{ ucfirst($p->status) }}
                                    </td>
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
