@extends('layouts.app')

@section('title', 'Models')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-4 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white">
                            <i class="bi bi-layers"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold text-dark">Models</h5>
                            <small class="text-muted">{{ $models->total() }} total models</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                        <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                            <a href="{{ route('models.sample') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-download me-1"></i>Sample
                            </a>
                            <a href="{{ route('models.export') }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel me-1"></i>Export
                            </a>
                            <a href="{{ route('models.create') }}" class="btn btn-sm btn-primary">
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
                <form action="{{ route('models.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
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
                                <th>Model Name</th>
                                <th style="width: 120px;">Products</th>
                                <th class="text-center pe-4" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($models as $m)
                            <tr class="table-row @if($m->trashed()) table-danger-subtle @endif">
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('models.products', $m->id) }}" class="text-decoration-none text-dark fw-semibold">
                                            {{ $m->model_name }}
                                        </a>
                                        @if($m->trashed())
                                            <span class="badge bg-danger ms-2">Archived</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $m->products_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="pe-4">
                                    @if(auth()->user()->permission <= 1)
                                        <div class="d-flex justify-content-center gap-1">
                                            @if($m->trashed())
                                                <form action="{{ route('models.restore', $m->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-light" title="Restore">
                                                        <i class="bi bi-arrow-counterclockwise text-success"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('models.edit', $m->id) }}" class="btn btn-sm btn-light" title="Edit">
                                                    <i class="bi bi-pencil text-warning"></i>
                                                </a>
                                                <form action="{{ route('models.destroy', $m->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light delete-btn"
                                                        data-title="Archive Model"
                                                        data-text="Archive {{ $m->model_name }}?"
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

                {{-- Pagination --}}
                @if($models->hasPages())
                <div class="px-3 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $models->firstItem() ?? 0 }} to {{ $models->lastItem() ?? 0 }} of {{ $models->total() }} results
                        </div>
                        {{ $models->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif

                {{-- Recycle Bin --}}
                @if(auth()->user()->permission <= 1 && $trashedModels->count() > 0)
                <div class="border-top bg-danger-subtle">
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
</div>
@endsection