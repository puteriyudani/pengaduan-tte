<!DOCTYPE html>
<html>

<head>
    <title>Laporan Detail Pengaduan TTE</title>
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

        h3 {
            color: #2980b9;
            text-align: center;
            margin-bottom: 5px;
        }

        h4 {
            color: #27ae60;
            margin-bottom: 4px;
        }

        .summary {
            font-weight: bold;
            margin-bottom: 8px;
            color: #c0392b;
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

        .status-pending {
            color: #d35400;
            font-weight: bold;
        }

        .status-selesai {
            color: #27ae60;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Laporan Detail Pengaduan Tanda Tangan Elektronik (TTE)</h2>

    @foreach ($pengaduanPerOpd as $opdId => $dataOpd)
        <div style="page-break-before: {{ !$loop->first ? 'always' : 'auto' }}">

            @php
                $namaOpd = optional($dataOpd->first()->opd)->nama_opd ?? 'Tidak Ada OPD';
                $totalAduan = $dataOpd->count();
                $totalPending = $dataOpd->where('status', 'pending')->count();
                $totalSelesai = $dataOpd->where('status', 'selesai')->count();
            @endphp

            <h3>OPD: {{ $namaOpd }}</h3>
            <div class="summary">
                Total Aduan: {{ $totalAduan }} |
                Pending: {{ $totalPending }} |
                Selesai: {{ $totalSelesai }}
            </div>

            @foreach ($dataOpd->groupBy('kategori.nama_kategori') as $kategori => $dataKategori)
                <h4>Kategori: {{ $kategori ?? 'Tanpa Kategori' }}</h4>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. WhatsApp</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKategori as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->whatsapp }}</td>
                                <td>{{ $p->keterangan }}</td>
                                <td class="status-{{ $p->status }}">{{ ucfirst($p->status) }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal ?? $p->created_at)->format('d-m-Y H:i') }}
                                </td>
                                <td>{{ $p->tanggal_selesai ? \Carbon\Carbon::parse($p->tanggal_selesai)->format('d-m-Y H:i') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    @endforeach
</body>

</html>
