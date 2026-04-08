@extends('layouts.app')

@section('title', 'Products')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card">
            {{-- Header --}}
            <div class="card-header bg-primary text-white py-3">
                <div class="row gy-3 align-items-center">
                    {{-- Title --}}
                    <div class="col-12 col-lg-2 d-flex align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Products</h5>
                        <span class="badge bg-light text-dark ms-2">{{ $products->total() }}</span>
                    </div>

                    {{-- AJAX Live Search --}}
                    <div class="col-12 col-lg-3">
                        <div class="position-relative">
                            <div class="input-group">
                                <input type="text" id="liveSearch" 
                                    class="form-control form-control-sm" 
                                    placeholder="Search serial no..."
                                    autocomplete="off">
                                <button class="btn btn-light btn-sm" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            {{-- Search Results Dropdown --}}
                            <div id="searchResults" class="position-absolute w-100 bg-white shadow-lg rounded border mt-1" style="z-index: 1000; display: none; max-height: 300px; overflow-y: auto;">
                            </div>
                        </div>
                        {{-- Hidden form for actual search --}}
                        <form id="searchForm" method="GET" action="{{ route('products.index') }}" class="d-none">
                            <input type="hidden" name="search" id="searchInput">
                        </form>
                    </div>

                    {{-- Filters --}}
                    <div class="col-12 col-lg-4">
                        <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2">
                            <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach(\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="brand_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Brands</option>
                                @foreach(\App\Models\Brand::all() as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>
                    </div>

                    {{-- Actions --}}
                    <div class="col-12 col-lg-3 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                <a href="{{ route('products.sample') }}" class="btn btn-sm btn-light text-primary">
                                    <i class="bi bi-download me-1"></i>Sample
                                </a>
                                <a href="{{ route('products.export.excel') }}" class="btn btn-sm btn-light text-success">
                                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                                </a>
                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-warning fw-bold">
                                    <i class="bi bi-plus-lg me-1"></i>Add Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Import Form --}}
            @if(auth()->user()->permission <= 1)
            <div class="card-body py-2 border-bottom">
                <form action="{{ route('products.import') }}" method="POST" 
                    enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="file" name="file" class="form-control form-control-sm" style="max-width: 200px;" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload me-1"></i>Import
                    </button>
                </form>
            </div>
            @endif

            {{-- Skipped Rows Alert --}}
            @if(Session::has('skippedRows') && count(Session::get('skippedRows')) > 0)
                <div class="m-3 alert alert-warning" role="alert">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong><i class="bi bi-exclamation-triangle me-1"></i>Skipped Rows ({{ count(Session::get('skippedRows')) }})</strong>
                            <div class="table-responsive mt-2" style="max-height: 200px;">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Reason</th>
                                            <th>Product Name</th>
                                            <th>Serial No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Session::get('skippedRows') as $row)
                                            <tr>
                                                <td>{{ $row['skip_reason'] ?? 'Unknown' }}</td>
                                                <td>{{ $row['product_name'] ?? 'N/A' }}</td>
                                                <td>{{ $row['serial_no'] ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.skipped.export') }}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-download"></i>
                            </a>
                            <form action="{{ route('products.skipped.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-close" aria-label="Close"></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Product</th>
                                <th>Serial No</th>
                                <th class="d-none d-md-table-cell">Location</th>
                                <th class="d-none d-lg-table-cell">User Desc</th>
                                <th class="d-none d-lg-table-cell">Remarks</th>
                                <th style="width: 100px;">Warranty</th>
                                <th style="width: 150px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $p)
                            <tr>
                                <td class="text-center text-muted">
                                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark">{{ $p->product_name }}</div>
                                    <small class="text-muted">{{ $p->category->category_name ?? '' }} | {{ $p->brand->brand_name ?? '' }}</small>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">{{ $p->serial_no ?? '-' }}</span>
                                </td>

                                <td class="d-none d-md-table-cell">{{ $p->position ?? '-' }}</td>

                                <td class="d-none d-lg-table-cell text-truncate" style="max-width: 150px;">
                                    {{ $p->user_description ?? '-' }}
                                </td>

                                <td class="d-none d-lg-table-cell text-truncate" style="max-width: 100px;">
                                    {{ $p->remarks ?? '-' }}
                                </td>

                                <td>{!! $p->warranty_countdown !!}</td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('products.show', $p->id) }}" 
                                        class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('products.edit', $p->id) }}" 
                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger delete-btn" 
                                                    data-title="Delete Product"
                                                    data-text="Delete {{ $p->product_name }}?"
                                                    title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('maintenance.create', ['product_id' => $p->id]) }}" 
                                            class="btn btn-sm btn-outline-primary" title="Maintenance">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                        <h6 class="fw-bold text-muted mt-3">No products found</h6>
                                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i>Add Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-3 border-top">
                    <x-pagination-block :paginator="$products" />
                </div>

                {{-- Recycle Bin --}}
                @if(\App\Models\Product::onlyTrashed()->count() > 0)
                <div class="card-body border-top bg-light">
                    <h6 class="text-danger fw-bold mb-3"><i class="bi bi-trash me-1"></i>Recycle Bin</h6>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Serial No</th>
                                    <th>Deleted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Product::onlyTrashed()->get() as $deleted)
                                <tr>
                                    <td>{{ $deleted->product_name }}</td>
                                    <td>{{ $deleted->serial_no }}</td>
                                    <td>{{ $deleted->deleted_at->format('d M Y') }}</td>
                                    <td>
                                        <form action="{{ route('products.restore', $deleted->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('products.forceDelete', $deleted->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger delete-btn" 
                                                data-title="Permanent Delete"
                                                data-text="Permanently delete {{ $deleted->product_name }}?">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearch');
    const searchResults = document.getElementById('searchResults');
    const searchForm = document.getElementById('searchForm');
    const searchHiddenInput = document.getElementById('searchInput');
    let debounceTimer;

    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    // Live search on keyup
    searchInput.addEventListener('keyup', function() {
        const query = this.value.trim();
        
        clearTimeout(debounceTimer);
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(function() {
            fetch('{{ route("products.search") }}?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="p-3 text-muted text-center">No products found</div>';
                    } else {
                        searchResults.innerHTML = data.map(product => `
                            <a href="/products/${product.id}" class="text-decoration-none">
                                <div class="p-2 border-bottom hover-bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold text-dark">${product.product_name}</div>
                                        <small class="text-muted">${product.serial_no || 'No serial'}</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </a>
                        `).join('');
                    }
                    searchResults.style.display = 'block';
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300);
    });

    // Submit form on Enter in search box (for full page search)
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchHiddenInput.value = searchInput.value;
            searchForm.submit();
        }
    });
});
</script>
@endpush
@endsection