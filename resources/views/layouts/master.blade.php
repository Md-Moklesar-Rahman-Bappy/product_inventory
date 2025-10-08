<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-light">

    {{-- 🔒 Authenticated Navbar --}}
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Inventory System</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">
                    {{ auth()->user()->name }} —
                    <strong>
                        {{ match(auth()->user()->permission) {
                            0 => 'Super Admin',
                            1 => 'Admin',
                            2 => 'Editor',
                            3 => 'Viewer',
                            default => 'Guest',
                        } }}
                    </strong>
                </span>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>
    @endauth

    <div class="container-fluid">
        <div class="row">
            {{-- 📚 Sidebar --}}
            <div class="col-md-3 col-lg-2 bg-white border-end vh-100 p-3">
                <h5 class="mb-4">Navigation</h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>

                    @if(auth()->user()->permission === 0)
                        <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link">Manage Users</a></li>
                    @endif

                    @if(in_array(auth()->user()->permission, [0, 1]))
                        <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Products</a></li>
                        <li class="nav-item"><a href="{{ route('products.create') }}" class="nav-link">Add Product</a></li>
                        <li class="nav-item"><a href="{{ route('activity.logs') }}" class="nav-link">Activity Logs</a></li>
                    @endif

                    <li class="nav-item"><a href="{{ route('profile') }}" class="nav-link">My Profile</a></li>
                </ul>
            </div>

            {{-- 📄 Main Content --}}
            <main class="col-md-9 col-lg-10 py-4 px-5">
                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                @yield('body')
            </main>
        </div>
    </div>

    {{-- 🧾 Footer --}}
    <footer class="text-center py-3 bg-white border-top mt-auto">
        <small>&copy; {{ date('Y') }} Product Inventory System. All rights reserved.</small>
    </footer>

</body>
</html>
