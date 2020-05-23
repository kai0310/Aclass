<!DOCTYPE html>
<html>
<head>
  <meta charset=UTF-8 />
  <meta name=viewport content="width=device-width,initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <style>
  *{margin:0;padding:0;line-height:2}
  body{font-family:'Noto Sans JP', sans-serif;background:#FAFAFA}
  h1{font-size:2rem;text-align:center;line-height:8rem}
  .inner{width:95%;max-width:1000px;margin:0 auto}
  .card{padding:.5rem 1rem;border-radius:.25rem;background:#FFF;box-shadow:0 2px 10px #0003}
  .card:nth-of-type(n+2){margin-top:calc(10px + 1.5rem)}
  </style>
  @yield('style')
</head>
<body>
  <header>
    <h1>Aclass</h1>
  </header>
  <main><div class=inner>@yield('content')</div></main>
</body>
</html>
