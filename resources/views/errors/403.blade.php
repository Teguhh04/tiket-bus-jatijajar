<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | JATIJAJAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e2a78 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 2rem;
        }
        .card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            max-width: 440px;
            width: 100%;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            display: block;
        }
        h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: #f97316;
        }
        p {
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        a {
            display: inline-block;
            background: #f97316;
            color: white;
            text-decoration: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        a:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class="card">
        <span class="icon">🚫</span>
        <h1>Akses Ditolak</h1>
        <p>Halaman ini hanya dapat diakses oleh administrator. Silakan login dengan akun admin yang valid.</p>
        <a href="/">Kembali ke Beranda</a>
    </div>
</body>
</html>
