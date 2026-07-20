<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Terjadi Kesalahan' }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .error-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            max-width: 500px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        }

        h1 {
            font-size: 70px;
            margin: 0;
            color: #dc3545;
        }

        h2 {
            margin-top: 10px;
            color: #333;
        }

        p {
            color: #666;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>

</head>

<body>

    <div class="error-container">

        <h1>{{ $code ?? '500' }}</h1>

        <h2>{{ $title ?? 'Terjadi Kesalahan' }}</h2>

        <p>
            {{ $message ?? 'Mohon maaf, terjadi kesalahan pada sistem. Silakan coba kembali beberapa saat lagi.' }}
        </p>

        <a href="{{ url('/') }}">
            Kembali ke Beranda
        </a>

    </div>

</body>

</html>
