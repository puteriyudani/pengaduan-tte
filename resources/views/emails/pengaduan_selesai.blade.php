<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pengaduan Selesai</title>
</head>

<body>
    <h3>Halo, {{ $pengaduan->nama }}</h3>
    <p>Pengaduan Anda dengan kategori <b>{{ $pengaduan->kategori->nama_kategori }}</b> telah selesai ditangani.</p>
    <p><b>Keterangan:</b></p>
    <p>{{ $pengaduan->keterangan }}</p>
    <br>
    <p>Terima kasih telah menggunakan layanan pengaduan TTE.</p>
</body>

</html>
