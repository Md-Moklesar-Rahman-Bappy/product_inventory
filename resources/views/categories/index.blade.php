@extends('layouts.app')

@section('title', 'Home Category')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

    {{-- Gradient Header --}}
    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #00C9FF, #92FE9D); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold">
        <i class="fa fa-list-alt me-2"></i> Category List
        <span class="badge bg-light text-dark ms-3">{{ $categories->total() }}</span>
      </h3>
      @if(auth()->user()->permission <= 1)
        <a href="{{ route('categories.create') }}" class="btn btn-lg fw-bold shadow-sm" style="background: linear-gradient(to right, #FF512F, #DD2476); color: white;">
          <i class="fa fa-plus me-1"></i> Add Category
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

      {{-- Category Table --}}
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm" style="min-width: 800px;">
          <thead style="background: linear-gradient(to right, #FFB75E, #ED8F03); color: white;">
            <tr style="height: 60px;">
              <th style="width: 80px;">SL</th>
              <th style="min-width: 200px;">Category</th>
              <th style="min-width: 220px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $c)
              <tr style="height: 55px;" @if($c->trashed()) class="table-danger" @endif>
                <td class="fw-bold text-primary">{{ $loop->iteration }}</td>
                <td class="fw-semibold">
                  <a href="{{ route('categories.products', $c->id) }}"
                     class="text-decoration-none text-dark fw-semibold"
                     style="transition: color 0.2s;"
                     onmouseover="this.style.color='#0d6efd'"
                     onmouseout="this.style.color=''"
                     title="View products under {{ $c->category_name }}">
                    {{ $c->category_name }}
                  </a>
                  @if($c->trashed())
                    <span class="badge bg-danger ms-2">Archived</span>
                  @endif
                </td>
                <td>
                  @if(auth()->user()->permission <= 1)
                    <div class="action-buttons">
                      @if($c->trashed())
                        <form action="{{ route('categories.restore', $c->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                            <i class="fa fa-undo"></i>
                          </button>
                        </form>
                      @else
                        <a href="{{ route('categories.edit', $c->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this category?')" style="display:inline;">
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
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No categories" width="100" class="mb-3 opacity-75">
                    <h5 class="fw-bold text-danger">No categories found</h5>
                    <p class="small">Start by adding a new category to your list.</p>
                    @if(auth()->user()->permission <= 1)
                      <a href="{{ route('categories.create') }}" class="btn btn-lg fw-bold" style="background: linear-gradient(to right, #FF512F, #DD2476); color: white;">
                        <i class="fa fa-plus me-1"></i> Add Category
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
      <x-pagination-block :paginator="$categories" />

      {{-- Recycle Bin Section --}}
      @if(auth()->user()->permission <= 1 && \App\Models\Category::onlyTrashed()->count() > 0 && !request()->has('show_trashed'))
        <div class="mt-5">
          <h5 class="text-danger fw-bold"><i class="fa fa-trash-alt me-2"></i> Recycle Bin</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center shadow-sm" style="min-width: 800px;">
              <thead class="bg-light">
                <tr>
                  <th>Category Name</th>
                  <th>Deleted At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach(\App\Models\Category::onlyTrashed()->get() as $deleted)
                  <tr class="table-danger">
                    <td class="fw-semibold">
                      {{ $deleted->category_name }}
                      <span class="badge bg-danger text-white ms-2">Archived</span>
                    </td>
                    <td>{{ $deleted->deleted_at->format('d M Y, h:i A') }}</td>
                    <td class="d-flex justify-content-center gap-2">
                      <form action="{{ route('categories.restore', $deleted->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-success" title="Restore Category">
                          <i class="fa fa-undo"></i> Restore
                        </button>
                      </form>

                      @if(auth()->user()->isSuperadmin())
                        <form action="{{ route('categories.forceDelete', $deleted->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Permanently delete this category?')" title="Force Delete">
                            <i class="fa fa-trash-alt"></i> Force Delete
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
@endsection
