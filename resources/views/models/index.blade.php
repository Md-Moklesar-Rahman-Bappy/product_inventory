@extends('layouts.app')

@section('title', 'Home Models')

@section('contents')
<div class="container py-5">
  {{-- Card Wrapper --}}
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

    {{-- Gradient Header --}}
    <div class="card-header text-white d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #00C9FF, #92FE9D); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold">
        <i class="fa fa-cubes me-1"></i> Model List
        <span class="badge bg-light text-dark ms-3">{{ $models->total() }}</span>
      </h3>
      @if(auth()->user()->permission <= 1)
        <a href="{{ route('models.create') }}" class="btn btn-lg fw-bold shadow-sm"
           style="background: linear-gradient(to right, #FF512F, #DD2476); color: white;">
          <i class="fa fa-plus me-1"></i> Add Model
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

      {{-- Model Table --}}
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm" style="min-width: 800px;">
          <thead style="background: linear-gradient(to right, #FFB75E, #ED8F03); color: white;">
            <tr style="height: 60px;">
              <th style="width: 80px;">SL</th>
              <th style="min-width: 200px;">Model</th>
              <th style="min-width: 220px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($models as $m)
              <tr style="height: 55px;" @if($m->trashed()) class="table-danger" @endif>
                <td class="fw-bold text-primary">
                  {{ $loop->iteration + ($models->currentPage() - 1) * $models->perPage() }}
                </td>
                <td class="fw-semibold">
                  <a href="{{ route('models.products', $m->id) }}"
                     class="text-decoration-none text-dark fw-semibold"
                     style="transition: color 0.2s;"
                     onmouseover="this.style.color='#0d6efd'"
                     onmouseout="this.style.color=''"
                     title="View products under {{ $m->model_name }}">
                    {{ $m->model_name }}
                  </a>
                  @if($m->trashed())
                    <span class="badge bg-danger ms-2">Archived</span>
                  @endif
                </td>
                <td>
                  @if(auth()->user()->permission <= 1)
                    <div class="action-buttons">
                      @if($m->trashed())
                        <form action="{{ route('models.restore', $m->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                            <i class="fa fa-undo"></i>
                          </button>
                        </form>
                      @else
                        <a href="{{ route('models.edit', $m->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('models.destroy', $m->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to archive this model?')" style="display:inline;">
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
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No models" width="100" class="mb-3 opacity-75">
                    <h5 class="fw-bold text-danger">No models found</h5>
                    <p class="small">Start by adding a new model to your list.</p>
                    @if(auth()->user()->permission <= 1)
                      <a href="{{ route('models.create') }}" class="btn btn-lg fw-bold"
                         style="background: linear-gradient(to right, #FF512F, #DD2476); color: white;">
                        <i class="fa fa-plus me-1"></i> Add Model
                      </a>
                    @endif
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>

        {{-- Pagination --}}
        <x-pagination-block :paginator="$models" />

        {{-- Recycle Bin Section --}}
        @if(auth()->user()->permission <= 1 && $trashedModels->total() > 0)
          <div class="mt-5">
            <h5 class="text-danger fw-bold"><i class="fa fa-trash-alt me-2"></i> Recycle Bin</h5>
            <table class="table table-bordered table-hover text-center">
              <thead class="bg-light">
                <tr>
                  <th>Model Name</th>
                  <th>Deleted At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($trashedModels as $deleted)
                <tr class="table-danger">
                  <td class="fw-semibold">
                    {{ $deleted->model_name }}
                    <span class="badge bg-danger text-white ms-2">Archived</span>
                  </td>
                  <td>{{ $deleted->deleted_at->format('d M Y, h:i A') }}</td>
                  <td>
                    <form action="{{ route('models.restore', $deleted->id) }}" method="POST">
                      @csrf
                      <button class="btn btn-sm btn-success fw-bold" title="Restore Model">
                        <i class="fa fa-undo"></i> Restore
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <x-pagination-block :paginator="$trashedModels" />
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
