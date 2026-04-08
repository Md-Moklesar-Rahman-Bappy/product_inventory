@extends('layouts.app')

@section('title', 'Products in ' . $model->model_name)

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card">
            {{-- Header --}}
            <div class="card-header bg-primary text-white py-3">
                <div class="row gy-3 align-items-center">
                    {{-- Title --}}
                    <div class="col-12 col-lg-3 d-flex align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Products in {{ $model->model_name }}</h5>
                        <span class="badge bg-light text-dark ms-2">{{ $products->total() }}</span>
                    </div>

                    {{-- Search --}}
                    <div class="col-12 col-lg-4">
                        <form method="GET" action="{{ route('models.products', $model->id) }}" class="d-flex gap-2">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm" placeholder="Search serial no...">
                                <button class="btn btn-light btn-sm" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Actions --}}
                    <div class="col-12 col-lg-5 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                <a href="{{ route('products.create', ['model_id' => $model->id]) }}" class="btn btn-sm btn-warning fw-bold">
                                    <i class="bi bi-plus-lg me-1"></i>Add Product
                                </a>
                                <a href="{{ route('products.export.model', $model->id) }}" class="btn btn-sm btn-light text-success">
                                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                                </a>
                            </div>
                        @endif
                        <a href="{{ route('models.index') }}" class="btn btn-sm btn-outline-light mt-2 mt-lg-0">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
            </div>

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
                                <th style="width: 120px;" class="text-center">Actions</th>
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
                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('products.create', ['model_id' => $model->id]) }}" class="btn btn-primary btn-sm mt-2">
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
                <div class="p-3 border-top">
                    <x-pagination-block :paginator="$products" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
