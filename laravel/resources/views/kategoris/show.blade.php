<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Detail Kategori</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $kategori->nama }}</h5>
                <p class="card-text">{{ $kategori->deskripsi }}</p>
                <p class="card-text"><small class="text-muted">Dibuat pada: {{ $kategori->created_at }}</small></p>
            </div>
        </div>
        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>