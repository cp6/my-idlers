<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <style>
            @charset "UTF-8";h1,p{margin-top:0}.container,.row{--bs-gutter-x:1.5rem;--bs-gutter-y:0}.row,body{display:flex}.main,.sub{text-align:center!important}:root{--bs-body-color-rgb:33,37,41;--bs-body-bg-rgb:255,255,255;--bs-font-sans-serif:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans","Liberation Sans",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--bs-font-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--bs-gradient:linear-gradient(180deg,rgba(255, 255, 255, 0.15),rgba(255, 255, 255, 0));--bs-body-font-family:var(--bs-font-sans-serif);--bs-body-font-size:1rem;--bs-body-font-weight:400;--bs-body-line-height:1.5;--bs-body-color:#212529;--bs-body-bg:#fff;--bs-border-width:1px;--bs-border-style:solid;--bs-border-color:#dee2e6;--bs-border-color-translucent:rgba(0, 0, 0, 0.175);--bs-border-radius:0.375rem;--bs-border-radius-sm:0.25rem;--bs-border-radius-lg:0.5rem;--bs-border-radius-xl:1rem;--bs-border-radius-2xl:2rem;--bs-border-radius-pill:50rem;--bs-link-color:#0d6efd;--bs-link-hover-color:#0a58ca;--bs-code-color:#d63384;--bs-highlight-bg:#fff3cd}*,::after,::before{box-sizing:border-box}@media (prefers-reduced-motion:no-preference){:root{scroll-behavior:smooth}}body{margin:0;font-family:var(--bs-body-font-family);font-size:var(--bs-body-font-size);font-weight:var(--bs-body-font-weight);line-height:var(--bs-body-line-height);color:var(--bs-body-color);text-align:var(--bs-body-text-align);background-color:var(--bs-body-bg);-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent}.main,h1{font-weight:500;line-height:1.2}h1{margin-bottom:.5rem;font-size:calc(1.375rem + 1.5vw)}p{margin-bottom:1rem}a{color:var(--bs-link-color);color:#277dfd;text-decoration:none}a:hover{color:var(--bs-link-hover-color)}.container,.row>*{width:100%;padding-right:calc(var(--bs-gutter-x) * .5);padding-left:calc(var(--bs-gutter-x) * .5)}.container{margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){h1{font-size:2.5rem}.container{max-width:1140px}}@media (min-width:1400px){.container{max-width:1320px}}.row{flex-wrap:wrap;margin-top:calc(-1 * var(--bs-gutter-y));margin-right:calc(-.5 * var(--bs-gutter-x));margin-left:calc(-.5 * var(--bs-gutter-x))}.row>*{flex-shrink:0;max-width:100%;margin-top:var(--bs-gutter-y)}.visually-hidden-focusable:not(:focus):not(:focus-within){position:absolute!important;width:1px!important;height:1px!important;padding:0!important;margin:-1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important;white-space:nowrap!important;border:0!important}.w-100{width:100%!important}.justify-content-center{justify-content:center!important}.m-auto{margin:auto!important}body,html{height:100%}body{align-items:center;background-color:#fbfbfb}.main{font-size:2.1rem;padding-bottom:.8rem!important;margin-bottom:0;padding-top:.2rem!important}.sub{font-size:1rem;font-weight:300;color:#000000a8}
        </style>
    </head>
    <body>
    <main class="w-100 m-auto">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="main">@yield('code')</h1>
                <p class="sub">@yield('message'). <a href="{{route('/')}}">Go home</a></p>
            </div>
        </div>
    </main>
    </body>
</html>
