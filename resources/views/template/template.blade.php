<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title') - BRIncubator</title>	
    @include('template/_head')
    @yield('head-extra')
</head>
<body class="adminbody">
<div id="main">
    @include('template/_header')
    @include('template/_sidebar')
    @yield('content')
    @include('template/_footer')
</div>
<!-- END main -->
@include('template/_js')
@yield('js-extra')
@yield('css-extra')
</body>
</html>