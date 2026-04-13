@extends('layouts.app')

@section('title', 'Categories')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-4 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white">
                            <i class="bi bi-tags"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold text-dark">Categories</h5>
                            <small class="text-muted">{{ $categories->total() }} total categories</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                        <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                            <a href="{{ route('categories.sample') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-download me-1"></i>Sample
                            </a>
                            <a href="{{ route('categories.export') }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel me-1"></i>Export
                            </a>
                            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
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
                <form action="{{ route('categories.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="file" name="file" class="form-control form-control-sm" style="max-width: 200px;" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload me-1"></i>Import
                    </button>
                    <small class="text-muted ms-auto">Supported: .xlsx, .csv</small>
                </form>
            </div>
            @endif

            {{-- Table Section --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>Category Name</th>
                                <th style="width: 120px;">Products</th>
                                <th class="text-center pe-4" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $c)
                            <tr class="table-row @if($c->trashed()) table-danger-subtle @endif">
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('categories.products', $c->id) }}" class="text-decoration-none text-dark fw-semibold">
                                            {{ $c->category_name }}
                                        </a>
                                        @if($c->trashed())
                                            <span class="badge bg-danger ms-2">Archived</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $c->products_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="pe-4">
                                    @if(auth()->user()->permission <= 1)
                                        <div class="d-flex justify-content-center gap-1">
                                            @if($c->trashed())
                                                <form action="{{ route('categories.restore', $c->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-light" title="Restore">
                                                        <i class="bi bi-arrow-counterclockwise text-success"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('categories.edit', $c->id) }}" class="btn btn-sm btn-light" title="Edit">
                                                    <i class="bi bi-pencil text-warning"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $c->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light delete-btn"
                                                        data-title="Archive Category"
                                                        data-text="Archive {{ $c->category_name }}?"
                                                        title="Archive">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon bg-light text-muted">
                                            <i class="bi bi-tags"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mt-3">No Categories Found</h6>
                                        <p class="text-muted mb-3">Get started by adding your first category</p>
                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-lg me-1"></i>Add Category
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
                @if($categories->hasPages())
                <div class="px-3 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} results
                        </div>
                        {{ $categories->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif

                {{-- Recycle Bin --}}
                @if(auth()->user()->permission <= 1 && \App\Models\Category::onlyTrashed()->count() > 0)
                <div class="border-top bg-danger-subtle">
                    <div class="px-3 py-2 d-flex align-items-center">
                        <i class="bi bi-trash text-danger me-2"></i>
                        <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                        <span class="badge bg-danger ms-2">{{ \App\Models\Category::onlyTrashed()->count() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Category</th>
                                    <th>Deleted</th>
                                    <th class="pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Category::onlyTrashed()->get() as $deleted)
                                <tr>
                                    <td class="ps-3">{{ $deleted->category_name }}</td>
                                    <td>{{ $deleted->deleted_at->format('d M Y') }}</td>
                                    <td class="pe-3">
                                        <form action="{{ route('categories.restore', $deleted->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                            </button>
                                        </form>
                                        @if(auth()->user()->isSuperadmin())
                                            <form action="{{ route('categories.forceDelete', $deleted->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger delete-btn"
                                                    data-title="Permanent Delete"
                                                    data-text="Permanently delete {{ $deleted->category_name }}?">
                                                    <i class="bi bi-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        @endif
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