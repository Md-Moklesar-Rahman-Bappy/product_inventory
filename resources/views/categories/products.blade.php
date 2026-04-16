@extends('layouts.app')

@section('title', 'Products in ' . $category->category_name)

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-2 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-tag-fill"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Products in {{ $category->category_name }}</h5>
                            <small class="text-white opacity-75">{{ $products->total() }} total items</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="liveSearch" placeholder="Search products..." autocomplete="off">
                            <div id="searchResults" class="search-results"></div>
                        </div>
                        <form id="searchForm" method="GET" action="{{ route('categories.products', $category->id) }}" class="d-none">
                            <input type="hidden" name="search" id="searchInput">
                        </form>
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="d-flex gap-2">
                            <select name="filter" class="form-select form-select-sm filter-select" onchange="this.form.submit()">
                                <option value="">All</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-arrow-left me-1"></i>Back
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('category.products.export', $category->id) }}">Export</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-lg me-1"></i>Add
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Product</th>
                            <th>Serial No</th>
                            <th class="d-none d-md-table-cell">Category</th>
                            <th class="d-none d-lg-table-cell">Location</th>
                            <th class="d-none d-lg-table-cell">Price</th>
                            <th style="width: 130px;">Warranty</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $p)
                        <tr>
                            <td class="ps-4">
                                <span class="row-number">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</span>
                            </td>

                            <td>
                                <div class="product-info">
                                    <div class="product-avatar">
                                        <i class="bi bi-box"></i>
                                    </div>
                                    <div>
                                        <div class="product-name">{{ $p->product_name }}</div>
                                        <div class="product-meta">
                                            {{ $p->brand->brand_name ?? 'N/A' }} | {{ $p->model->model_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <code class="serial-code">{{ $p->serial_no ?? '-' }}</code>
                            </td>

                            <td class="d-none d-md-table-cell">
                                <span class="category-badge">
                                    <i class="bi bi-tag-fill"></i>
                                    {{ $p->category->category_name ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="d-none d-lg-table-cell">
                                <span class="location-text">{{ $p->position ?? '—' }}</span>
                            </td>

                            <td class="d-none d-lg-table-cell">
                                <span class="price-value">
                                    <span class="price-symbol">৳</span>{{ number_format($p->price ?? 0, 2) }}
                                </span>
                            </td>

                            <td>
                                @if($p->warranty_end)
                                    @php
                                        $daysLeft = now()->diffInDays($p->warranty_end, false);
                                        $warrantyClass = $daysLeft < 0 ? 'warranty-expired' : ($daysLeft <= 30 ? 'warranty-expiring' : 'warranty-active');
                                        $warrantyIcon = $daysLeft < 0 ? 'x-circle-fill' : ($daysLeft <= 30 ? 'exclamation-circle-fill' : 'check-circle-fill');
                                        $warrantyText = $daysLeft < 0 ? 'Expired' : $daysLeft . ' days';
                                    @endphp
                                    <span class="warranty-badge {{ $warrantyClass }}">
                                        <i class="bi bi-{{ $warrantyIcon }}"></i>
                                        {{ $warrantyText }}
                                    </span>
                                @else
                                    <span class="warranty-none">— No Warranty</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('products.show', $p->id) }}" 
                                       class="action-btn action-btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('products.edit', $p->id) }}" 
                                           class="action-btn action-btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Products Found</h6>
                                    <p class="text-muted mb-3">Get started by adding your first product</p>
                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="btn btn-primary btn-sm">
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

            @if($products->hasPages())
            <div class="table-footer">
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
