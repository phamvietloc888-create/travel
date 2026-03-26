<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f4f7fb;
            --panel: #ffffff;
            --line: #dbe4ee;
            --text: #102033;
            --muted: #6c7c8f;
            --accent: #0f6cbd;
            --admin: #7c3aed;
            --user: #0f766e;
            --auth: #b45309;
            --public: #1d4ed8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background: linear-gradient(180deg, #eff5ff 0%, var(--bg) 100%);
            color: var(--text);
        }

        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }

        .hero {
            margin-bottom: 24px;
            padding: 28px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: var(--panel);
            box-shadow: 0 18px 42px rgba(16, 32, 51, 0.08);
        }

        .hero h1 {
            margin: 0 0 8px;
            font-size: 36px;
        }

        .hero p {
            margin: 0;
            color: var(--muted);
        }

        .hero-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .hero-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 16px;
            border-radius: 999px;
            border: 1px solid var(--line);
            color: var(--text);
            background: #f8fbff;
            text-decoration: none;
            font-weight: 700;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat {
            padding: 18px;
            border-radius: 20px;
            background: var(--panel);
            border: 1px solid var(--line);
        }

        .stat strong {
            display: block;
            font-size: 30px;
        }

        .stat span {
            color: var(--muted);
        }

        .group {
            margin-bottom: 24px;
            padding: 22px;
            border-radius: 24px;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: 0 14px 34px rgba(16, 32, 51, 0.06);
        }

        .group h2 {
            margin: 0 0 6px;
            font-size: 28px;
        }

        .group p {
            margin: 0 0 18px;
            color: var(--muted);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 18px;
        }

        .table th,
        .table td {
            padding: 14px 12px;
            border-bottom: 1px solid #edf2f7;
            text-align: left;
            vertical-align: top;
        }

        .table th {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
        }

        .table tr:last-child td {
            border-bottom: 0;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .pill-public { background: var(--public); }
        .pill-auth { background: var(--auth); }
        .pill-user { background: var(--user); }
        .pill-admin { background: var(--admin); }

        .path-link {
            color: var(--accent);
            text-decoration: none;
            word-break: break-all;
        }

        .meta {
            color: var(--muted);
            font-size: 13px;
        }

        @media (max-width: 900px) {
            .table,
            .table thead,
            .table tbody,
            .table th,
            .table td,
            .table tr {
                display: block;
            }

            .table thead {
                display: none;
            }

            .table tr {
                padding: 14px 0;
                border-bottom: 1px solid #edf2f7;
            }

            .table td {
                padding: 8px 0;
                border: 0;
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <h1>Sitemap tong hop</h1>
            <p>Xem toan bo URL dang sinh tu route va database, gom Public, Auth, User va Admin.</p>
            <p class="meta">Generated at: {{ $generatedAt->format('d/m/Y H:i:s') }}</p>
            <div class="hero-links">
                <a href="{{ url('/sitemap.xml') }}" target="_blank" rel="noopener">Mo sitemap.xml</a>
                <a href="{{ url('/') }}" target="_blank" rel="noopener">Ve trang chu</a>
            </div>
        </section>

        <section class="stats">
            <div class="stat">
                <strong>{{ $items->count() }}</strong>
                <span>Tong URL</span>
            </div>
            @foreach($groupedItems as $group => $groupItems)
                <div class="stat">
                    <strong>{{ $groupItems->count() }}</strong>
                    <span>{{ $group }}</span>
                </div>
            @endforeach
        </section>

        @foreach($groupedItems as $group => $groupItems)
            @php
                $pillClass = match ($group) {
                    'Public' => 'pill-public',
                    'Auth' => 'pill-auth',
                    'User' => 'pill-user',
                    'Admin' => 'pill-admin',
                    default => 'pill-public',
                };
            @endphp

            <section class="group">
                <h2>{{ $group }}</h2>
                <p>{{ $groupItems->count() }} URL</p>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nhom</th>
                            <th>Ten</th>
                            <th>Method</th>
                            <th>URL</th>
                            <th>Access</th>
                            <th>Lastmod</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupItems as $item)
                            <tr>
                                <td><span class="pill {{ $pillClass }}">{{ $item['section'] }}</span></td>
                                <td>{{ $item['label'] }}</td>
                                <td><strong>{{ $item['method'] }}</strong></td>
                                <td><a class="path-link" href="{{ $item['loc'] }}" target="_blank" rel="noopener">{{ $item['loc'] }}</a></td>
                                <td>{{ $item['access'] }}</td>
                                <td class="meta">{{ $item['lastmod'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endforeach
    </div>
</body>
</html>
