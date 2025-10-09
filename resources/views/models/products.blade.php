@extends('layouts.app')

@section('title', 'Products in ' . $model->model_name)

@section('contents')
<div class="row">
  <div class="col-lg-12">
    <div class="card">

      {{-- 🔖 Header --}}
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
        <div class="d-flex align-items-center gap-3">
          <h3 class="mb-0 fw-bold">
            <i class="fa fa-cubes me-2"></i> Products in {{ $model->model_name }}
          </h3>
          <span class="badge bg-light text-dark fs-6 fw-semibold">{{ $products->total() }} items</span>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center">

          {{-- 🔍 Search --}}
          <form method="GET" action="{{ route('models.products', $model->id) }}" class="d-flex" style="max-width: 400px;">
            <div class="input-group">
              <input type="text" name="search" value="{{ request('search') }}"
                class="form-control bg-light border-0 small" placeholder="Search by Serial Number" aria-label="Search">
              <button class="btn btn-info" type="submit">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </form>

          @if(auth()->user()->permission <= 1)
            {{-- ➕ Add Product --}}
            <a href="{{ route('products.create', ['model_id' => $model->id]) }}"
               class="btn btn-success fw-semibold shadow-sm">
              <i class="fa fa-plus me-1"></i> Add Product
            </a>

            {{-- 📤 Export --}}
            <a href="{{ route('products.export.model', $model->id) }}" class="btn btn-outline-success">
              📤 Export for {{ $model->model_name }}
            </a>
          @endif

          {{-- 🔙 Back --}}
          <a href="{{ route('models.index') }}"
             class="btn btn-warning fw-semibold shadow-sm text-white">
            <i class="fa fa-arrow-left me-1"></i> Back to Models
          </a>
        </div>
      </div>

      {{-- 📦 Body --}}
      <div class="card-body bg-light p-4">

        {{-- ✅ Success Toast --}}
        @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible fade show shadow-sm fw-semibold" role="alert">
            <i class="fa fa-check-circle me-1"></i> {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        {{-- 📋 Product Table --}}
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle text-center shadow-sm rounded"
            style="min-width: 1200px; border-radius: 0.5rem; overflow: hidden;">
            <thead style="background: linear-gradient(to right, #00C9FF, #92FE9D); color: white;">
              <tr class="text-uppercase fw-bold" style="height: 60px;">
                <th>SL</th>
                <th>Product</th>
                <th>Price</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Serial No</th>
                <th>Project Serial</th>
                <th>Location</th>
                <th>User Description</th>
                <th>Remarks</th>
                <th>Warranty</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($products as $product)
                <tr style="height: 55px; background-color: {{ $loop->even ? '#f9f9f9' : '#ffffff' }};">
                  <td class="fw-bold text-primary">
                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                  </td>
                  <td class="fw-semibold text-dark" title="{{ $product->product_name }}">
                    {{ $product->product_name }}
                  </td>
                  <td>{{ number_format($product->price, 2) }} ৳</td>
                  <td title="{{ $product->brand->brand_name ?? '-' }}">
                    {{ $product->brand->brand_name ?? '-' }}
                  </td>
                  <td title="{{ $product->category->category_name ?? '-' }}">
                    {{ $product->category->category_name ?? '-' }}
                  </td>
                  <td title="{{ $product->serial_no }}">
                    {{ $product->serial_no }}
                  </td>
                  <td title="{{ $product->project_serial ?? '-' }}">
                    {{ $product->project_serial ?? '-' }}
                  </td>
                  <td title="{{ $product->position ?? '-' }}">
                    {{ $product->position ?? '-' }}
                  </td>
                  <td title="{{ $product->user_description ?? '-' }}">
                    {{ $product->user_description ?? '-' }}
                  </td>
                  <td title="{{ $product->remarks ?? '-' }}">
                    {{ $product->remarks ?? '-' }}
                  </td>
                  <td title="{{ strip_tags($product->warranty_countdown) }}">
                    {!! $product->warranty_countdown !!}
                  </td>
                  <td>
                    <div class="d-flex justify-content-center gap-2">
                      <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info" title="View">
                        <i class="fa fa-eye"></i>
                      </a>
                      @if(auth()->user()->permission <= 1)
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="12" class="text-center py-5 text-muted">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                      <i class="fa fa-box-open fa-2x mb-3 text-danger"></i>
                      <h5 class="fw-bold">No products found for this model</h5>
                      <p class="small">Try adding a new product under this model to populate the list.</p>
                      @if(auth()->user()->permission <= 1)
                        <a href="{{ route('products.create', ['model_id' => $model->id]) }}"
                           class="btn btn-primary fw-bold mt-2 shadow-sm">
                          <i class="fa fa-plus me-1"></i> Add Product
                        </a>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- 📄 Pagination --}}
        <x-pagination-block :paginator="$products" />
      </div>
    </div>
  </div>
</div>
@endsection
