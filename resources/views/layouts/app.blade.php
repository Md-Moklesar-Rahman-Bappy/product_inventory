<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 🌐 Meta & Favicon -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Inventory - @yield('title', 'Dashboard')</title>

    <!-- 🖼️ Favicon Variants -->
    <link rel="icon" type="image/x-icon" href="{{ asset('resources/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('resources/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('resources/favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('resources/favicon/apple-touch-icon.png') }}">
    <link rel="android-chrome-192x192" href="{{ asset('resources/favicon/android-chrome-192x192.png') }}">
    <link rel="android-chrome-512x512" href="{{ asset('resources/favicon/android-chrome-512x512.png') }}">

    <!-- 🖋️ Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- 🎨 Component Styles -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}">

    <!-- 📦 Page-specific styles -->
    @stack('styles')
</head>

<body id="page-top">
  <!-- 🔧 Main Wrapper -->
  <div id="wrapper">
    @include('layouts.sidebar') <!-- 📚 Sidebar Navigation -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.navbar') <!-- 📌 Top Navigation -->

        <!-- 📄 Page Content -->
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
          </div>

          @yield('contents') <!-- 🧩 Dynamic Page Content -->
        </div>
      </div>

      @include('layouts.footer') <!-- 📎 Footer -->
    </div>
  </div>

  <!-- 🔝 Scroll-to-Top Button -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- ⚙️ Core Scripts -->
  <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/chart.js/Chart.min.js') }}"></script>

  <!-- 📦 Plugin Scripts -->
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  <script>
    $(document).ready(function () {
      // 🖼️ Initialize Dropify file input
      $('.dropify').dropify({
        messages: {
          'default': 'Drag and drop a file here or click',
          'replace': 'Drag and drop or click to replace',
          'remove':  'Remove',
          'error':   'Ooops, something wrong happened.'
        }
      });
    });
  </script>

  <!-- 📦 Page-specific scripts -->
  @stack('scripts')
</body>
</html>
