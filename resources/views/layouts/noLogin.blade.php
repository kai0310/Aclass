<!DOCTYPE html>
<meta charset=UTF-8 />
<meta name=viewport content="width=device-width,initial-scale=1.0">
<meta name=csrf-token content="{{ csrf_token() }}">
<title>{{ config('app.name') }}</title>
<link rel=icon href="{{url('favicon.ico')}}" />
<link rel=apple-touch-icon sizes=180x180 href="{{url('apple-touch-icon.png')}}">
<link rel=stylesheet href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
<style>{!! str_replace("<", "&lt;", file_get_contents(resource_path('views/layouts/common.css'))) !!}</style>
@yield('style')
<header>
  <div class=inner>
    <img src="{{url('storage/logo.svg')}}" />
  </div>
</header>
<main><div class=inner>@yield('content')</div></main>
<footer></footer>
@yield('script')
