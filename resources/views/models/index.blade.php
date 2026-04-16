@extends('layouts.app')

@section('title', 'Models')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-2 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-layers"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Models</h5>
                            <small class="text-white opacity-75">{{ $models->total() }} total</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="liveSearch" placeholder="Search models..." autocomplete="off">
                            <div id="searchResults" class="search-results"></div>
                        </div>
                        <form id="searchForm" method="GET" action="{{ route('models.index') }}" class="d-none">
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
                                <a href="{{ route('models.sample') }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-download me-1"></i>Sample
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('models.export') }}">Export</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('models.create') }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-lg me-1"></i>Add
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(auth()->user()->permission <= 1)
            <div class="import-section">
                <form action="{{ route('models.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="file" name="file" class="form-control form-control-sm" style="max-width: 200px;" accept=".xlsx,.xls,.csv" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload me-1"></i>Import
                    </button>
                    <small class="text-muted ms-auto">Supported: .xlsx, .csv, .xls</small>
                </form>
            </div>
            @endif

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>Model Name</th>
                            <th style="width: 120px;">Products</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($models as $m)
                        <tr @if($m->trashed()) class="bg-danger-subtle" @endif>
                            <td class="ps-4">
                                <span class="row-number">{{ ($models->currentPage() - 1) * $models->perPage() + $loop->iteration }}</span>
                            </td>
                            <td>
                                <a href="{{ route('models.products', $m->id) }}" class="product-name text-decoration-none">
                                    <i class="bi bi-layers-fill me-2 text-info"></i>{{ $m->model_name }}
                                </a>
                                @if($m->trashed())
                                    <span class="badge bg-danger ms-2">Archived</span>
                                @endif
                            </td>
                            <td>
                                <span class="category-badge">
                                    <i class="bi bi-box"></i>
                                    {{ $m->products_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                @if(auth()->user()->permission <= 1)
                                    <div class="action-buttons">
                                        @if($m->trashed())
                                            <form action="{{ route('models.restore', $m->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="action-btn action-btn-view" title="Restore">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('models.edit', $m->id) }}" class="action-btn action-btn-edit" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('models.destroy', $m->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn action-btn-delete delete-btn"
                                                    data-title="Archive Model"
                                                    data-text="Archive {{ $m->model_name }}?"
                                                    title="Archive">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-layers"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Models Found</h6>
                                    <p class="text-muted mb-3">Get started by adding your first model</p>
                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('models.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Add Model
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($models->hasPages())
            <div class="table-footer">
                {{ $models->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif

            @if(auth()->user()->permission <= 1 && $trashedModels->count() > 0)
            <div class="recycle-bin-section">
                <div class="px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-trash text-danger me-2"></i>
                    <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                    <span class="badge bg-danger ms-2">{{ $trashedModels->count() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Model</th>
                                <th>Deleted</th>
                                <th class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedModels as $deleted)
                            <tr>
                                <td class="ps-3">{{ $deleted->model_name }}</td>
                                <td>{{ $deleted->deleted_at->format('d M Y') }}</td>
                                <td class="pe-3">
                                    <form action="{{ route('models.restore', $deleted->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('models.forceDelete', $deleted->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger delete-btn"
                                            data-title="Permanent Delete"
                                            data-text="Permanently delete {{ $deleted->model_name }}?">
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
@endsection
