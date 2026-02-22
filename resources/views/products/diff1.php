@extends('layouts.app')

@section('title', 'Home Product')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- Header --}}
            <div class="card-header text-white py-4" style="background: linear-gradient(90deg, #00bcd4, #2196f3);">
                <div class="row align-items-center g-3">
                    {{-- Title & Count --}}
                    <div class="col-md-4">
                        <h3 class="mb-0 fw-bold">
                            <i class="fa fa-boxes me-2"></i> Product Inventory
                            <span class="badge bg-light text-dark ms-3">{{ $products->total() }} items</span>
                        </h3>
                    </div>

                    {{-- Search Bar --}}
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('products.index') }}" class="d-flex justify-content-center">
                            <div class="input-group" style="max-width: 400px; width: 100%;">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control bg-light border-0 small"
                                    placeholder="Search by Product, Serial No, or Project Serial No"
                                    aria-label="Search by Product, Serial No, or Project Serial No">
                                <button class="btn btn-primary" type="submit" aria-label="Search">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-4 text-end">
                        @if(auth()->user()->permission <= 1)
                            <div class="d-flex justify-content-end align-items-center gap-2 flex-wrap">
                            <a href="{{ route('products.create') }}" class="btn btn-warning fw-bold shadow-sm">
                                <i class="fa fa-plus me-1"></i> Add Product
                            </a>
                            <a href="{{ route('products.export.excel') }}" class="btn btn-info">
                                📤 Export All
                            </a>
                            <a href="{{ route('products.sample') }}" class="btn btn-secondary">
                                📄 Sample CSV
                            </a>
                            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                <input type="file" name="file" class="form-control" style="width:200px;" required>
                                <button type="submit" class="btn btn-success">
                                    📥 Import Products
                                </button>
                            </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Skipped Rows Alert --}}
        @if(Session::has('skippedRows') && count(Session::get('skippedRows')) > 0)
        <div class="alert alert-warning alert-dismissible fade show shadow-sm fw-semibold" role="alert">
            <i class="fa fa-exclamation-triangle me-1"></i>
            Some rows were skipped during import:

            <div class="table-responsive mt-2">
                <table class="table table-sm table-bordered table-striped mb-0 small">
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

            {{-- Download skipped rows --}}
            <a href="{{ route('products.skipped.export') }}" class="btn btn-sm btn-outline-dark mt-2">
                <i class="fa fa-download"></i> Download Skipped Rows CSV
            </a>

            {{-- X button that clears skipped rows session --}}
            <form action="{{ route('products.skipped.clear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-close" aria-label="Close"></button>
            </form>
        </div>
        @endif

        {{-- Body --}}
        <div class="card-body bg-light p-4">
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm fw-semibold" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm fw-semibold" role="alert">
                <i class="fa fa-exclamation-circle me-1"></i> {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center shadow-sm product-table">
                    <thead class="text-uppercase fw-bold text-primary" style="background-color: #e3f2fd;">
                        <tr>
                            <th style="width: 50px;">SL</th>
                            <th style="min-width: 80px;">Product</th>
                            {{-- <th style="min-width: 90px;">Price</th> --}}
                            <th style="min-width: 90px;">Serial No</th>
                            <th class="d-none-xs" style="min-width: 80px;">Project Serial</th>
                            <th class="d-none-xs" style="min-width: 70px;">Location</th>
                            <th class="d-none-md" style="min-width: 100px;">User Description</th>
                            <th class="d-none-sm" style="min-width: 80px;">Remarks</th>
                            <th style="min-width: 90px;">Warranty</th>
                            <th style="min-width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr>
                            <td class="fw-bold text-primary">
                                {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                            </td>
                            <td class="fw-semibold text-dark tooltip-cell" title="{{ $p->product_name }}">
                                @if(request('search'))
                                {!! str_replace(request('search'), '<mark>' . e(request('search')) . '</mark>', e($p->product_name)) !!}
                                @else
                                {{ $p->product_name }}
                                @endif
                            </td>
                            {{-- <td>{{ number_format($p->price, 2) }} ৳</td> --}}
                            <td class="tooltip-cell" title="{{ $p->serial_no }}">
                                @if(request('search'))
                                {!! str_replace(request('search'), '<mark>' . e(request('search')) . '</mark>', e($p->serial_no)) !!}
                                @else
                                {{ $p->serial_no ?? '-' }}
                                @endif
                            </td>
                            <td class="d-none-xs tooltip-cell" title="{{ $p->project_serial_no }}">
                                @if(request('search'))
                                {!! str_replace(request('search'), '<mark>' . e(request('search')) . '</mark>', e($p->project_serial_no)) !!}
                                @else
                                {{ $p->project_serial_no ?? '-' }}
                                @endif
                            </td>
                            <td class="d-none-xs tooltip-cell" title="{{ $p->position }}">
                                {{ $p->position ?? '-' }}
                            </td>
                            <td class="d-none-md tooltip-cell" title="{{ $p->user_description }}">
                                {{ $p->user_description ?? '-' }}
                            </td>
                            <td class="d-none-sm tooltip-cell" title="{{ $p->remarks }}">
                                {{ $p->remarks ?? '-' }}
                            </td>
                            <td>{!! $p->warranty_countdown !!}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('products.show', $p->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $p->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('maintenance.create', ['product_id' => $p->id]) }}"
                                            class="btn btn-sm btn-outline-primary" title="Send to Maintenance">
                                            <i class="fa fa-tools me-1"></i>
                                        </a>
                                        @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No products" width="100" class="mb-3 opacity-75">
                                    <h5 class="fw-bold text-danger">No products found</h5>
                                    <a href="{{ route('products.create') }}" class="btn btn-outline-primary btn-lg fw-bold">
                                        <i class="fa fa-plus me-1"></i> Add Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <x-pagination-block :paginator="$products" />

            <!-- Recycle Bin Section -->
            @if(\App\Models\Product::onlyTrashed()->count() > 0)
            <div class="mt-4">
                <h5 class="text-danger">🗑️ Recycle Bin</h5>
                <div class="table-responsive">
                    <table class="table table-bordered product-table">
                        <thead class="bg-light">
                            <tr>
                                <th>Product Name</th>
                                <th>Serial No</th>
                                <th class="d-none-sm">Deleted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Product::onlyTrashed()->get() as $deleted)
                            <tr>
                                <td class="tooltip-cell" title="{{ $deleted->product_name }}">
                                    {{ Str::limit($deleted->product_name, 15, '...') }}
                                </td>
                                <td>{{ $deleted->serial_no }}</td>
                                <td class="d-none-sm">{{ $deleted->deleted_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <form action="{{ route('products.restore', $deleted->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-success" title="Restore Product">
                                            <i class="fa fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('products.forceDelete', $deleted->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Permanently Delete">
                                            <i class="fa fa-trash"></i> Delete Permanently
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