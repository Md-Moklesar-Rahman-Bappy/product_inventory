@extends('layouts.app')

@section('title', 'Home Product')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- Header --}}
            <div class="card-header text-white py-4" style="background: linear-gradient(90deg, #00bcd4, #2196f3);">
                <div class="row align-items-center g-3">
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

        {{-- Body --}}
        <div class="card-body bg-light p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle shadow-sm product-table">
                    <thead class="text-uppercase fw-bold text-primary" style="background-color: #e3f2fd;">
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th class="d-none d-sm-table-cell">Serial No</th>
                            <th class="d-none d-md-table-cell">Project Serial</th>
                            <th class="d-none d-md-table-cell">Location</th>
                            <th class="d-none d-lg-table-cell">User Description</th>
                            <th class="d-none d-lg-table-cell">Remarks</th>
                            <th>Warranty</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr>
                            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                            <td>{{ $p->product_name }}</td>
                            <td class="d-none d-sm-table-cell">{{ $p->serial_no ?? '-' }}</td>
                            <td class="d-none d-md-table-cell">{{ $p->project_serial_no ?? '-' }}</td>
                            <td class="d-none d-md-table-cell">{{ $p->position ?? '-' }}</td>
                            <td class="d-none d-lg-table-cell">{{ $p->user_description ?? '-' }}</td>
                            <td class="d-none d-lg-table-cell">{{ $p->remarks ?? '-' }}</td>
                            <td>{!! $p->warranty_countdown !!}</td>
                            <td>
                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <a href="{{ route('products.show', $p->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $p->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('maintenance.create', ['product_id' => $p->id]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-tools me-1"></i>
                                        </a>
                                        @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted align-middle">
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
                    <table class="table table-bordered text-center align-middle product-table">
                        <thead class="bg-light">
                            <tr>
                                <th>Product Name</th>
                                <th>Serial No</th>
                                <th class="d-none d-sm-table-cell">Deleted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Product::onlyTrashed()->get() as $deleted)
                            <tr>
                                <td>{{ Str::limit($deleted->product_name, 15, '...') }}</td>
                                <td>{{ $deleted->serial_no }}</td>
                                <td class="d-none d-sm-table-cell">{{ $deleted->deleted_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('products.restore', $deleted->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-success">
                                                <i class="fa fa-undo"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('products.forceDelete', $deleted->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> Delete Permanently
                                            </button>
                                        </form>
                                    </div>
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