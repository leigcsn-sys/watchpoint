<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Too Many Requests</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background: #fff;
            font-family: 'Inter', sans-serif;
            color: #111111;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .box { text-align: center; }
        .code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 12px;
        }
        h1 { font-size: 22px; font-weight: 500; margin: 0 0 16px; }
        a {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #111111;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="box">
        <p class="code">429 — rate limited</p>
        <h1>Slow down a little.</h1>
        <a href="{{ url('/watches') }}">&larr; back to watches</a>
    </div>
</body>
</html>