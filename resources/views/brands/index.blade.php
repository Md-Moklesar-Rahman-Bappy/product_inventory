@extends('layouts.app')

@section('title', 'Brands')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card">
            {{-- Header --}}
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-award me-2"></i>Brands</h5>
                    @if(auth()->user()->permission <= 1)
                    <div class="d-flex gap-2">
                        <a href="{{ route('brands.sample') }}" class="btn btn-sm btn-light text-primary">
                            <i class="bi bi-download me-1"></i>Sample
                        </a>
                        <a href="{{ route('brands.export') }}" class="btn btn-sm btn-light text-success">
                            <i class="bi bi-file-earmark-excel me-1"></i>Export
                        </a>
                        <a href="{{ route('brands.create') }}" class="btn btn-sm btn-warning fw-bold">
                            <i class="bi bi-plus-lg me-1"></i>Add
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Import Form --}}
            @if(auth()->user()->permission <= 1)
            <div class="card-body py-2 border-bottom">
                <form action="{{ route('brands.import') }}" method="POST" 
                    enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="file" name="file" class="form-control form-control-sm" style="max-width: 200px;" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload me-1"></i>Import
                    </button>
                </form>
            </div>
            @endif

            {{-- Body --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Brand Name</th>
                                <th style="width: 150px;">Products</th>
                                <th style="width: 150px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $b)
                            <tr @if($b->trashed()) class="table-danger" @endif>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('brands.products', $b->id) }}" class="text-decoration-none text-dark fw-semibold">
                                            {{ $b->brand_name }}
                                        </a>
                                        @if($b->trashed())
                                            <span class="badge bg-danger ms-2">Archived</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $b->products_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if(auth()->user()->permission <= 1)
                                        <div class="d-flex justify-content-center gap-1">
                                            @if($b->trashed())
                                                <form action="{{ route('brands.restore', $b->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('brands.edit', $b->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('brands.destroy', $b->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-title="Archive Brand"
                                                        data-text="Archive {{ $b->brand_name }}?"
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
                                <td colspan="4" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                        <h6 class="fw-bold text-muted mt-3">No brands found</h6>
                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm mt-2">
                                                <i class="bi bi-plus-lg me-1"></i>Add Brand
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
                <div class="p-3 border-top">
                    <x-pagination-block :paginator="$brands" />
                </div>

                {{-- Recycle Bin --}}
                @if(auth()->user()->permission <= 1 && $trashedBrands->count() > 0)
                <div class="card-body border-top bg-light py-3">
                    <h6 class="text-danger fw-bold mb-3"><i class="bi bi-trash me-1"></i>Recycle Bin</h6>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Brand</th>
                                    <th>Deleted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trashedBrands as $deleted)
                                <tr>
                                    <td>{{ $deleted->brand_name }}</td>
                                    <td>{{ $deleted->deleted_at->format('d M Y') }}</td>
                                    <td>
                                        <form action="{{ route('brands.restore', $deleted->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('brands.forceDelete', $deleted->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger delete-btn"
                                                data-title="Permanent Delete"
                                                data-text="Permanently delete {{ $deleted->brand_name }}?">
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