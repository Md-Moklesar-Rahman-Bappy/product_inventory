@extends('layouts.app')

@section('title', 'Warranty Overview')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4">
    <div class="card-header bg-primary text-white py-3">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h3 class="mb-0 fw-bold">
          <i class="fa fa-shield-alt me-2"></i> Product Warranties
        </h3>

        <form method="GET" class="d-flex align-items-center gap-2">
          <select name="warranty_status" class="form-select w-auto">
            <option value="">All</option>
            <option value="active" {{ request('warranty_status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="expired" {{ request('warranty_status') === 'expired' ? 'selected' : '' }}>Expired</option>
          </select>
          <button type="submit" class="btn btn-light">Filter</button>
        </form>
      </div>
    </div>

    <div class="card-body bg-light px-4 py-5">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm">
          <thead class="bg-light text-uppercase fw-bold text-primary">
            <tr>
              <th scope="col">SL</th>
              <th scope="col">Product Name</th>
              <th scope="col">Serial No</th>
              <th scope="col">Project Serial</th>
              <th scope="col">Warranty Ends</th>
              <th scope="col">Countdown</th>
            </tr>
          </thead>
          <tbody>
            @php $lastUrgency = null; @endphp

            @forelse($products as $index => $p)
              @php
                $urgency = $p->urgency_level;
                $now = \Carbon\Carbon::now();
                $end = \Carbon\Carbon::parse($p->warranty_end);
                $expired = $p->warranty_end && $end->isPast();
              @endphp

              {{-- Section Header --}}
              @if($urgency !== $lastUrgency)
                <tr>
                  <td colspan="6" class="bg-secondary text-white fw-bold text-start px-3">
                    @switch($urgency)
                      @case(0) Expired Warranties @break
                      @case(1) Expiring in 7 Days @break
                      @case(2) Expiring in 30 Days @break
                      @case(3) Active Warranties @break
                      @case(4) No Warranty Info @break
                      @default Unknown
                    @endswitch
                  </td>
                </tr>
                @php $lastUrgency = $urgency; @endphp
              @endif

              {{-- Product Row --}}
              <tr class="{{ $expired ? 'table-danger' : '' }}">
                <td>{{ $products->firstItem() + $index }}</td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->serial_no }}</td>
                <td>{{ $p->project_serial_no }}</td>
                <td>{{ $p->warranty_end ? $end->format('d M Y') : '—' }}</td>
                <td>
                  @if($p->warranty_end && $p->warranty_start)
                    @php
                      if ($expired) {
                          $badgeText = 'Expired';
                          $badgeClass = 'bg-danger text-white';
                          $tooltip = 'Expired on ' . $end->format('d M Y');
                      } else {
                          $totalMinutes = $now->diffInMinutes($end);
                          $totalDays = floor($totalMinutes / (60 * 24));
                          $remainingHours = floor(($totalMinutes % (60 * 24)) / 60);

                          $badgeText = "{$totalDays} days {$remainingHours} hours";
                          $tooltip = 'Ends on ' . $end->format('d M Y');

                          if ($totalDays <= 7) {
                              $badgeClass = 'bg-danger text-white';
                          } elseif ($totalDays <= 30) {
                              $badgeClass = 'bg-warning text-dark';
                          } else {
                              $badgeClass = 'bg-success text-white';
                          }
                      }
                    @endphp

                    <span class="badge {{ $badgeClass }}" data-bs-toggle="tooltip" title="{{ $tooltip }}">
                      {{ $badgeText }}
                    </span>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-muted py-5 text-center">
                  <i class="fa fa-shield-alt fa-2x mb-3 text-danger"></i>
                  <h5 class="fw-bold">No warranty data found</h5>
                  <p class="small">Make sure products have warranty info assigned.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <x-pagination-block :paginator="$products" />
    </div>
  </div>
</div>

{{-- Tooltip Script --}}
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>
@endpush
@endsection
