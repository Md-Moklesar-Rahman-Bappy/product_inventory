@extends('layouts.app')

@section('title', 'Home Brands')

@section('contents')
<div class="container py-5">
  {{-- Card Wrapper --}}
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

    {{-- Gradient Header --}}
    <div class="card-header text-white d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #00C9FF, #92FE9D); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold">
        <i class="fa fa-tags me-2"></i> Brand List
        <span class="badge bg-light text-dark ms-3">{{ $brands->total() }}</span>
      </h3>
      @if(auth()->user()->permission <= 1)
        <a href="{{ route('brands.create') }}" class="btn btn-lg fw-bold shadow-sm"
           style="background: linear-gradient(to right, #FF512F, #DD2476); color: white;">
          <i class="fa fa-plus me-1"></i> Add Brand
        </a>
      @endif
    </div>

    {{-- Card Body --}}
    <div class="card-body bg-light" style="padding: 2rem;">

      {{-- Success Message --}}
      @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm fw-semibold" role="alert">
          <i class="fa fa-check-circle me-1"></i> {{ Session::get('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      {{-- Brand Table --}}
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm" style="min-width: 800px;">
          <thead style="background: linear-gradient(to right, #FFB75E, #ED8F03); color: white;">
            <tr style="height: 60px;">
              <th style="width: 80px;">SL</th>
              <th style="min-width: 200px;">Brand</th>
              <th style="min-width: 220px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($brands as $brand)
              <tr style="height: 55px;" @if($brand->trashed()) class="table-danger" @endif>
                <td class="fw-bold text-primary">
                  {{ $loop->iteration + ($brands->currentPage() - 1) * $brands->perPage() }}
                </td>
                <td class="fw-semibold">
                  <a href="{{ route('brands.products', $brand->id) }}"
                     class="text-decoration-none text-dark fw-semibold"
                     style="transition: color 0.2s;"
                     onmouseover="this.style.color='#0d6efd'"
                     onmouseout="this.style.color=''"
                     title="View products under {{ $brand->brand_name }}">
                    {{ $brand->brand_name }}
                  </a>
                  @if($brand->trashed())
                    <span class="badge bg-danger ms-2">Archived</span>
                  @endif
                </td>
                <td>
                  @if(auth()->user()->permission <= 1)
                    <div class="action-buttons">
                      @if($brand->trashed())
                        <form action="{{ route('brands.restore', $brand->id) }}" method="POST">
                          @csrf
                          <button class="btn btn-sm btn-outline-success fw-bold" title="Restore">
                            <i class="fa fa-undo"></i>
                          </button>
                        </form>
                      @else
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to archive this brand?')" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger" title="Archive">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      @endif
                    </div>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center py-5 text-muted">
                  <div class="d-flex flex-column align-items-center justify-content-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No brands" width="100" class="mb-3 opacity-75">
                    <h5 class="fw-bold text-danger">No brands found</h5>
                    <p class="small">Start by adding a new brand to your inventory.</p>
                    @if(auth()->user()->permission <= 1)
                      <a href="{{ route('brands.create') }}" class="btn btn-lg fw-bold"
                         style="background: linear-gradient(to right, #FF512F, #DD2476); color: white;">
                        <i class="fa fa-plus me-1"></i> Add Brand
                      </a>
                    @endif
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>

        {{-- Pagination --}}
        <x-pagination-block :paginator="$brands" />

        {{-- Recycle Bin Section --}}
        @if(auth()->user()->permission <= 1 && $trashedBrands->total() > 0)
          <div class="mt-5">
            <h5 class="text-danger fw-bold"><i class="fa fa-trash-alt me-2"></i> Recycle Bin</h5>
            <table class="table table-bordered table-hover text-center">
              <thead class="bg-light">
                <tr>
                  <th>Brand Name</th>
                  <th>Deleted At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($trashedBrands as $deleted)
                <tr class="table-danger">
                  <td class="fw-semibold">
                    {{ $deleted->brand_name }}
                    <span class="badge bg-danger text-white ms-2">Archived</span>
                  </td>
                  <td>{{ $deleted->deleted_at->format('d M Y, h:i A') }}</td>
                  <td>
                    <form action="{{ route('brands.restore', $deleted->id) }}" method="POST">
                      @csrf
                      <button class="btn btn-sm btn-success fw-bold" title="Restore Brand">
                        <i class="fa fa-undo"></i> Restore
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <x-pagination-block :paginator="$trashedBrands" />
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
