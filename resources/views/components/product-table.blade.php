<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
</div>@props(['products'])

<div class="table-responsive">
  <table class="table table-hover table-bordered align-middle text-center shadow-sm rounded"
         style="min-width: 1200px; border-radius: 0.5rem; overflow: hidden;">
    <thead style="background: linear-gradient(to right, #00C9FF, #92FE9D); color: white;">
      <tr class="text-uppercase fw-bold" style="height: 60px;">
        <th>SL</th>
        <th>Product</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Category</th>
        <th>Serial No</th>
        <th>Project Serial</th>
        <th>Position</th>
        <th>User Description</th>
        <th>Remarks</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $product)
        <tr style="height: 55px; background-color: {{ $loop->even ? '#f9f9f9' : '#ffffff' }};">
          <td class="fw-bold text-primary">{{ $loop->iteration }}</td>
          <td class="fw-semibold text-dark" title="{{ $product->product_name }}">
            {{ \Illuminate\Support\Str::limit($product->product_name, 8) }}
          </td>
          <td title="{{ $product->brand->brand_name ?? '-' }}">
            {{ \Illuminate\Support\Str::limit($product->brand->brand_name ?? '-', 8) }}
          </td>
          <td title="{{ $product->model->model_name ?? '-' }}">
            {{ \Illuminate\Support\Str::limit($product->model->model_name ?? '-', 8) }}
          </td>
          <td title="{{ $product->category->category_name ?? '-' }}">
            {{ \Illuminate\Support\Str::limit($product->category->category_name ?? '-', 8) }}
          </td>
          <td title="{{ $product->serial_no }}">
            {{ \Illuminate\Support\Str::limit($product->serial_no, 8) }}
          </td>
          <td title="{{ $product->project_serial ?? '-' }}">
            {{ \Illuminate\Support\Str::limit($product->project_serial ?? '-', 8) }}
          </td>
          <td title="{{ $product->position ?? '-' }}">
            {{ \Illuminate\Support\Str::limit($product->position ?? '-', 8) }}
          </td>
          <td title="{{ $product->user_description ?? '-' }}">
            {{ \Illuminate\Support\Str::limit($product->user_description ?? '-', 8) }}
          </td>
          <td title="{{ $product->remarks ?? '-' }}">
            {{ \Illuminate\Support\Str::limit($product->remarks ?? '-', 8) }}
          </td>
          <td>
            <div class="d-flex justify-content-center gap-2">
              <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info" title="View">
                <i class="fa fa-eye"></i>
              </a>
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                <i class="fa fa-edit"></i>
              </a>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="11" class="text-center py-5 text-muted">
            <div class="d-flex flex-column align-items-center justify-content-center">
              <i class="fa fa-box-open fa-2x mb-3 text-danger"></i>
              <h5 class="fw-bold">No products found</h5>
              <p class="small">Try adding a new product to populate the list.</p>
            </div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Pagination --}}
<div class="mt-4">
  {{ $products->links() }}
</div>
