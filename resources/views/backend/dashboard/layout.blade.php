<!doctype html>
<html lang="vn">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('backend.dashboard.components.head')
</head>

<body>
    <div id="layout-wrapper">
        <!-- navbar header  -->
        @include('backend.dashboard.components.header')
        <!-- sidebar -->
        @include('backend.dashboard.components.sidebar')
        <!-- main content -->
        @include($template)
        <!-- footer  -->
        @include('backend.dashboard.components.footer')
        
    </div>
    <!-- footer  -->
    @include('backend.dashboard.components.script')
    @yield('js')
</body>

</html>