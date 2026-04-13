@extends('layouts.app')

@section('title', 'Products')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-2 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white me-3">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Products</h5>
                            <small class="text-muted">{{ $products->total() }} total items</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="liveSearch" placeholder="Search products..." autocomplete="off">
                            <div id="searchResults" class="search-results"></div>
                        </div>
                        <form id="searchForm" method="GET" action="{{ route('products.index') }}" class="d-none">
                            <input type="hidden" name="search" id="searchInput">
                        </form>
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="d-flex gap-2">
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
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                <a href="{{ route('products.sample') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download me-1"></i>Sample
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('products.export.excel') }}">Excel Format</a></li>
                                        <li><a class="dropdown-item" href="{{ route('products.export.category') }}">By Category</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i>Add
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Import Section --}}
            @if(auth()->user()->permission <= 1)
            <div class="border-bottom px-3 py-2 bg-light-subtle">
                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="file" name="file" class="form-control form-control-sm" style="max-width: 200px;" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload me-1"></i>Import
                    </button>
                    <small class="text-muted ms-auto">Supported: .xlsx, .csv, .xls</small>
                </form>
            </div>
            @endif

            {{-- Skipped Rows Alert --}}
            @if(Session::has('skippedRows') && count(Session::get('skippedRows')) > 0)
                <div class="m-3 alert alert-warning d-flex align-items-start" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">
                        <strong>Skipped Rows ({{ count(Session::get('skippedRows')) }})</strong>
                        <div class="table-responsive mt-2" style="max-height: 150px;">
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
                                        <td><span class="badge bg-warning text-dark">{{ $row['skip_reason'] ?? 'Unknown' }}</span></td>
                                        <td>{{ $row['product_name'] ?? 'N/A' }}</td>
                                        <td><code>{{ $row['serial_no'] ?? 'N/A' }}</code></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex gap-2 ms-3">
                        <a href="{{ route('products.skipped.export') }}" class="btn btn-sm btn-outline-dark" title="Export">
                            <i class="bi bi-download"></i>
                        </a>
                        <form action="{{ route('products.skipped.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-close" aria-label="Close"></button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Table Section --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>Product Info</th>
                                <th>Serial No</th>
                                <th class="d-none d-md-table-cell">Category</th>
                                <th class="d-none d-lg-table-cell">Location</th>
                                <th class="d-none d-lg-table-cell">Price</th>
                                <th style="width: 120px;">Warranty</th>
                                <th class="text-center pe-4" style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $p)
                            <tr class="table-row">
                                <td class="ps-4 text-muted">
                                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar bg-primary-subtle text-primary rounded-circle me-3">
                                            <i class="bi bi-box"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $p->product_name }}</div>
                                            <small class="text-muted">
                                                {{ $p->brand->brand_name ?? 'N/A' }} | {{ $p->model->model_name ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <code class="bg-light px-2 py-1 rounded">{{ $p->serial_no ?? '-' }}</code>
                                </td>

                                <td class="d-none d-md-table-cell">
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $p->category->category_name ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="d-none d-lg-table-cell">
                                    <span class="text-muted">{{ $p->position ?? '—' }}</span>
                                </td>

                                <td class="d-none d-lg-table-cell">
                                    <span class="fw-semibold">৳{{ number_format($p->price ?? 0, 2) }}</span>
                                </td>

                                <td>
                                    @if($p->warranty_end)
                                        @php
                                            $daysLeft = now()->diffInDays($p->warranty_end, false);
                                            $badgeClass = $daysLeft < 0 ? 'bg-danger' : ($daysLeft <= 30 ? 'bg-warning' : 'bg-success');
                                            $textClass = $daysLeft <= 30 ? 'text-dark' : 'text-white';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} {{ $textClass }}">
                                            @if($daysLeft < 0)
                                                Expired
                                            @else
                                                {{ $daysLeft }} days
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td class="pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('products.show', $p->id) }}" 
                                           class="btn btn-sm btn-light" title="View">
                                            <i class="bi bi-eye text-info"></i>
                                        </a>

                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('products.edit', $p->id) }}" 
                                               class="btn btn-sm btn-light" title="Edit">
                                                <i class="bi bi-pencil text-warning"></i>
                                            </a>

                                            <a href="{{ route('maintenance.create', ['product_id' => $p->id]) }}" 
                                               class="btn btn-sm btn-light" title="Maintenance">
                                                <i class="bi bi-tools text-primary"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="btn btn-sm btn-light delete-btn" 
                                                    data-title="Delete Product"
                                                    data-text="Delete {{ $p->product_name }}?"
                                                    title="Delete">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon bg-light text-muted">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mt-3">No Products Found</h6>
                                        <p class="text-muted mb-3">Get started by adding your first product</p>
                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-lg me-1"></i>Add Product
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                <div class="px-3 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                        </div>
                        {{ $products->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif

                {{-- Recycle Bin --}}
                @if(\App\Models\Product::onlyTrashed()->count() > 0)
                <div class="border-top bg-danger-subtle">
                    <div class="px-3 py-2 d-flex align-items-center">
                        <i class="bi bi-trash text-danger me-2"></i>
                        <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                        <span class="badge bg-danger ms-2">{{ \App\Models\Product::onlyTrashed()->count() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th>Serial No</th>
                                    <th>Deleted</th>
                                    <th class="pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Product::onlyTrashed()->get() as $deleted)
                                <tr>
                                    <td class="ps-3">{{ $deleted->product_name }}</td>
                                    <td><code>{{ $deleted->serial_no }}</code></td>
                                    <td>{{ $deleted->deleted_at->format('d M Y') }}</td>
                                    <td class="pe-3">
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
@endsection

@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearch');
    const searchResults = document.getElementById('searchResults');
    const searchForm = document.getElementById('searchForm');
    const searchHiddenInput = document.getElementById('searchInput');
    let debounceTimer;

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.remove('show');
        }
    });

    searchInput.addEventListener('keyup', function() {
        const query = this.value.trim();
        clearTimeout(debounceTimer);
        
        if (query.length < 2) {
            searchResults.classList.remove('show');
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
                            <a href="/products/${product.id}" class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold text-dark">${product.product_name}</div>
                                    <small class="text-muted">${product.serial_no || 'No serial'}</small>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                        `).join('');
                    }
                    searchResults.classList.add('show');
                })
                .catch(error => console.error('Search error:', error));
        }, 300);
    });

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