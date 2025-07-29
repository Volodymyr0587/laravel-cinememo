<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Content Items Export</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
            background-color: #f8f9fa;
            color: #212529;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 28px;
            color: #343a40;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
        }

        .content-item {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            page-break-inside: avoid;
        }

        .content-item h2 {
            font-size: 20px;
            margin-top: 0;
            color: #007bff;
        }

        .content-item p {
            margin: 5px 0;
            font-size: 14px;
        }

        .label {
            font-weight: bold;
            color: #6c757d;
        }

        .image {
            margin-top: 10px;
            max-width: 100%;
            width: 200px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>🎬 My Cinememo Export</h1>

    @foreach ($contentItems as $item)
        <div class="content-item">
            <h2>{{ $item->title }}</h2>
            <p><span class="label">Status:</span> {{ ucfirst($item->status->value) }}</p>
            <p><span class="label">Type:</span> {{ $item->contentType->name ?? '-' }}</p>
            @if ($item->image_url)
                <img src="{{ public_path($item->image_url) }}" alt="Image for {{ $item->title }}" class="image">
            @endif
        </div>
    @endforeach

</body>
</html>
