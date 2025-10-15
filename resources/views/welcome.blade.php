<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>BE Portfolio</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
      href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700"
      rel="stylesheet"
    />

    <!-- If Vite exists, still load it for consistency (but design stands alone) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
      :root { --fg:#1b1b18; --muted:#6b6b66; --line:#e9e9e6; --bg:#FDFDFC; --accent:#111111; --radius:14px; }
      * { box-sizing:border-box; }
      html,body { height:100%; }
      body { margin:0; font-family:'Instrument Sans', ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, 'Apple Color Emoji','Segoe UI Emoji'; color:var(--fg); background:var(--bg); }
      .container { max-width:920px; margin-inline:auto; padding:20px 14px; }
      @media (min-width: 640px) { .container { padding:28px 18px; } }
      @media (min-width: 960px) { .container { padding:32px 20px; } }

      .hero { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; flex-wrap:wrap; }
      @media (max-width: 600px){ .hero { flex-direction:column; align-items:flex-start; gap:10px; } }

      .brand { display:flex; align-items:center; gap:10px; min-width:0; }
      .mark { height:36px; width:36px; border-radius:10px; background:var(--accent); color:white; display:grid; place-items:center; font-weight:700; letter-spacing:.5px; flex:0 0 auto; }
      @media (min-width: 640px){ .mark { height:40px; width:40px; border-radius:12px; } }
      .title { font-size:18px; font-weight:600; line-height:1.25; }
      @media (min-width: 640px){ .title { font-size:20px; } }
      .subtitle { font-size:12px; color:var(--muted); }

      .badges { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
      .badge { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border:1px solid var(--line); border-radius:999px; font-size:12px; background:#fff; }

      .main { display:grid; grid-template-columns:1fr; gap:14px; }
      @media (min-width: 960px) { .main { grid-template-columns: 1.4fr .9fr; gap:16px; } }

      .card { background:#fff; border:1px solid var(--line); border-radius:var(--radius); box-shadow:0 6px 20px rgba(0,0,0,.04); overflow:hidden; }
      .card > .hd { padding:10px 12px; border-bottom:1px solid var(--line); font-size:13px; color:var(--muted); display:flex; align-items:center; justify-content:space-between; gap:8px; }
      .card > .bd { padding:14px; }

      .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:10px 14px; border-radius:10px; border:1px solid var(--line); background:#fff; text-decoration:none; color:inherit; font-weight:500; transition:transform .12s ease; min-height:40px; }
      .btn:hover { transform:translateY(-1px); }
      .btns { display:grid; grid-template-columns:1fr; gap:8px; }
      @media (min-width: 520px){ .btns { grid-template-columns: repeat(3, minmax(0,1fr)); } }

      .grid-3 { display:grid; grid-template-columns:1fr; gap:8px; }
      @media (min-width:680px){ .grid-3 { grid-template-columns:repeat(3,1fr); gap:10px; } }

      .kpi { padding:12px; border:1px solid var(--line); border-radius:12px; }
      .kpi .k { font-size:12px; color:var(--muted); margin-bottom:4px; }
      .kpi .v { font-size:15px; font-weight:600; word-break:break-word; }

      pre,code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; }
      pre { margin:0; padding:12px; background:#fbfbfa; border-top:1px solid var(--line); border-bottom-left-radius:var(--radius); border-bottom-right-radius:var(--radius); overflow:auto; }

      .list { list-style:none; padding:0; margin:0; display:grid; gap:8px; }
      .list a { text-decoration:underline; text-underline-offset:3px; word-break:break-all; }

      footer { text-align:center; font-size:12px; color:var(--muted); margin-top:20px; }
    </style>
  </head>

  <body>
    <div class="container">
      <header class="hero" aria-label="Service header">
        <div class="brand">
          <div class="mark" aria-hidden="true">GK</div>
          <div>
            <div class="title">Gkomunika Core Service API</div>
            <div class="subtitle">Light welcome page</div>
          </div>
        </div>
        <div class="badges">
          <span class="badge"><span style="display:inline-block;height:8px;width:8px;border-radius:50%;background:#10b981"></span>Healthy</span>
          <span class="badge">{{ config('app.version', 'v1') }}</span>
          <span class="badge">{{ strtoupper(app()->environment()) }}</span>
        </div>
      </header>

      <main class="main">
        <section class="card">
          <div class="hd">
            <span>Quick start</span>
            <button id="copyBtn" class="btn" type="button" style="min-width:96px;">Copy</button>
          </div>
          <div class="bd">
            <div class="btns" style="margin-bottom:12px;">
              <a class="btn" href="{{ url('/docs') }}">API Docs</a>
              <a class="btn" href="{{ url('/openapi.json') }}">OpenAPI</a>
              <a class="btn" href="{{ url('/health') }}">Health</a>
            </div>
            <pre id="curlBlock"><code>curl -i {{ url('/ping') }}</code></pre>
          </div>
          <div class="bd">
            <div class="grid-3">
              <div class="kpi"><div class="k">Laravel</div><div class="v">{{ app()->version() }}</div></div>
              <div class="kpi"><div class="k">PHP</div><div class="v">{{ PHP_VERSION }}</div></div>
              <div class="kpi"><div class="k">Server time</div><div class="v">{{ now()->toDateTimeString() }}</div></div>
            </div>
          </div>
        </section>

        <aside class="card">
          <div class="hd">Endpoints</div>
          <div class="bd">
            <ul class="list">
              <li>
                <a href="{{ url('/ping') }}">GET /ping</a>
                <span style="font-size:12px;color:var(--muted);margin-left:6px;">200 OK</span>
              </li>
              <li>
                <a href="{{ url('/health') }}">GET /health</a>
                <span style="font-size:12px;color:var(--muted);margin-left:6px;">200 OK</span>
              </li>
              <li>
                <a href="{{ url('/docs') }}">GET /docs</a>
                <span style="font-size:12px;color:var(--muted);margin-left:6px;">Swagger</span>
              </li>
              <li>
                <a href="{{ url('/openapi.json') }}">GET /openapi.json</a>
                <span style="font-size:12px;color:var(--muted);margin-left:6px;">Schema</span>
              </li>
            </ul>
          </div>
        </aside>
      </main>

      <footer>© {{ date('Y') }} Gkomunika</footer>
    </div>

    <script>
      (function () {
        const btn = document.getElementById('copyBtn');
        const blk = document.getElementById('curlBlock');
        btn?.addEventListener('click', async () => {
          try { await navigator.clipboard.writeText((blk?.innerText||'').trim()); btn.textContent='Copied!'; setTimeout(()=>btn.textContent='Copy', 1200);} catch(_){}
        });
      })();
    </script>
  </body>
</html>
