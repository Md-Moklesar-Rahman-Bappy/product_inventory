@extends('layouts.app')

@section('title', 'Warranty Overview')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-4 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold text-dark">Product Warranties</h5>
                            <small class="text-muted">{{ $products->total() }} total products</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 text-lg-end">
                        <form method="GET" class="d-flex gap-2 justify-content-lg-end">
                            <select name="warranty_status" class="form-select form-select-sm" style="width: 120px;">
                                <option value="">All</option>
                                <option value="active" {{ request('warranty_status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="expired" {{ request('warranty_status') === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 50px;">#</th>
                                <th>Product Name</th>
                                <th>Serial No</th>
                                <th>Project Serial</th>
                                <th>Category</th>
                                <th style="width: 120px;">Warranty Ends</th>
                                <th style="width: 140px;">Status</th>
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

                            @if($urgency !== $lastUrgency)
                            <tr>
                                <td colspan="7" class="bg-light-subtle fw-bold text-dark px-4 py-2">
                                    @switch($urgency)
                                        @case(0) <i class="bi bi-exclamation-triangle text-danger me-2"></i> Expired Warranties @break
                                        @case(1) <i class="bi bi-exclamation-circle text-warning me-2"></i> Expiring in 7 Days @break
                                        @case(2) <i class="bi bi-clock text-info me-2"></i> Expiring in 30 Days @break
                                        @case(3) <i class="bi bi-check-circle text-success me-2"></i> Active Warranties @break
                                        @case(4) <i class="bi bi-dash-circle text-muted me-2"></i> No Warranty Info @break
                                        @default Unknown
                                    @endswitch
                                </td>
                            </tr>
                            @php $lastUrgency = $urgency; @endphp
                            @endif

                            <tr class="table-row @if($expired) table-danger-subtle @endif">
                                <td class="ps-4 text-muted">{{ $products->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $p->product_name }}</div>
                                </td>
                                <td><code>{{ $p->serial_no ?? '—' }}</code></td>
                                <td><span class="text-muted">{{ $p->project_serial_no ?? '—' }}</span></td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $p->category->category_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $p->warranty_end ? $end->format('d M Y') : '—' }}</span>
                                </td>
                                <td>
                                    @if($p->warranty_end && $p->warranty_start)
                                        @php
                                            if ($expired) {
                                                $badgeText = 'Expired';
                                                $badgeClass = 'bg-danger text-white';
                                            } else {
                                                $totalDays = floor($now->diffInMinutes($end) / (60 * 24));
                                                $badgeText = "{$totalDays} days left";
                                                $badgeClass = $totalDays <= 7 ? 'bg-danger text-white' : ($totalDays <= 30 ? 'bg-warning text-dark' : 'bg-success text-white');
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon bg-light text-muted">
                                            <i class="bi bi-shield-check"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mt-3">No Warranty Data</h6>
                                        <p class="text-muted mb-0">Make sure products have warranty info assigned</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                <div class="px-3 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                        </div>
                        {{ $products->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection