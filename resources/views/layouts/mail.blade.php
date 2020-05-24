<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width,initial-scale=1.0">
    <style>{!! str_replace("<", "&lt;", file_get_contents(resource_path('views/layouts/mail.css'))) !!}</style>
  </head>
  <body>
    <main>
      <div style=height:5rem></div>
      <h2>@yield('title')</h2>
      <hr>
      <p>@yield('content')</p>
      <nav><a href="@yield('link')" target="_blank" ontouchstart="">詳細を見る</a></nav>
    </main>
  </body>
</html>
