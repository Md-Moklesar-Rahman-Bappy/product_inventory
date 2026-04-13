@extends('layouts.app')

@section('title', 'Products in ' . $category->category_name)

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-3 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white me-3">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Products in {{ $category->category_name }}</h5>
                            <small class="text-muted">{{ $products->total() }} total items</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <form method="GET" action="{{ route('categories.products', $category->id) }}" class="d-flex gap-2">
                            <div class="search-box flex-grow-1">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm" placeholder="Search products...">
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-lg-5 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i>Add
                                </a>
                                <a href="{{ route('category.products.export', $category->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                                </a>
                            </div>
                        @endif
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light mt-2 mt-lg-0">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 50px;">#</th>
                                <th>Product</th>
                                <th>Serial No</th>
                                <th class="d-none d-md-table-cell">Category</th>
                                <th class="d-none d-lg-table-cell">Location</th>
                                <th class="d-none d-lg-table-cell">Price</th>
                                <th style="width: 120px;">Warranty</th>
                                <th class="text-center pe-4" style="width: 120px;">Actions</th>
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
            </div>
        </div>
    </div>
</div>
@endsection