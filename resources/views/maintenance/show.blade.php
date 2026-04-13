@extends('layouts.app')

@section('title', 'Maintenance Details')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary text-white me-3">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Maintenance Details</h5>
                            <small class="text-muted">Record #{{ $maintenance->id }}</small>
                        </div>
                    </div>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-primary-subtle text-primary me-3">
                            <i class="bi bi-box"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Product Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Product Name</span>
                                <span class="detail-value">{{ $maintenance->product->product_name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Serial No</span>
                                <span class="detail-value"><code>{{ $maintenance->product->serial_no ?? 'N/A' }}</code></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-warning-subtle text-warning me-3">
                            <i class="bi bi-wrench"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Maintenance Details</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="detail-card">
                                <span class="detail-label">Issue / Description</span>
                                <span class="detail-value">{{ $maintenance->description }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Start Date</span>
                                <span class="detail-value">{{ $maintenance->start_time->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">End Date</span>
                                <span class="detail-value">{{ $maintenance->end_time->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    @if(now()->between($maintenance->start_time, $maintenance->end_time))
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    @elseif(now()->lt($maintenance->start_time))
                                        <span class="badge bg-info text-dark">Scheduled</span>
                                    @else
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-info-subtle text-info me-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Logged By</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">User Name</span>
                                <span class="detail-value">{{ $maintenance->user->name ?? 'System' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-light text-muted me-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Record Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Created At</span>
                                <span class="detail-value">{{ $maintenance->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Last Updated</span>
                                <span class="detail-value">{{ $maintenance->updated_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between pt-3 border-top">
                    <a href="{{ route('maintenance.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                    @if(auth()->user()->permission <= 1)
                    <div class="d-flex gap-2">
                        <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('maintenance.destroy', $maintenance->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn"
                                data-title="Delete Record"
                                data-text="Are you sure you want to delete this maintenance record?">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection