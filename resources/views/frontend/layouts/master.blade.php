@include('frontend.layouts.header')
<body>

@include('frontend.layouts.navbar')
@include('setting::layouts.alert')

   @yield('content')
@include('frontend.layouts.footer')
</body>
