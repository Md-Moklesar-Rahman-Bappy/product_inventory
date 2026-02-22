@extends('layouts.app')

@section('title', 'Edit Maintenance Record')

@section('contents')
    <div class="container py-5">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-warning text-dark py-3">
                <h3 class="mb-0 fw-bold">
                    <i class="fa fa-tools me-2"></i> Edit Maintenance #{{ $maintenance->id }}
                </h3>
            </div>

            <div class="card-body bg-light px-4 py-5">
                @if($errors->any())
                    <div class="alert alert-danger shadow-sm fw-semibold mb-4">
                        <i class="fa fa-exclamation-circle me-1"></i> Please fix the errors below
                    </div>
                @endif

                <form action="{{ route('maintenance.update', $maintenance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- 📦 Product Info --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa fa-box-open me-1"></i> Product Info
                        </label>
                        <div class="bg-white border rounded px-3 py-2 shadow-sm">
                            <span class="fw-semibold text-dark">
                                {{ $maintenance->product->product_name }}
                            </span>
                            <span class="badge bg-light text-muted ms-2">
                                {{ $maintenance->product->serial_no }}
                            </span>
                        </div>
                    </div>

                    {{-- 🛡️ Warranty Info (Product Index Style) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa fa-shield-alt me-1"></i> Warranty
                        </label>
                        <div
                            class="bg-white border rounded px-3 py-3 shadow-sm d-flex justify-content-between align-items-center">
                            <div>
                                @if($maintenance->product->warranty_start && $maintenance->product->warranty_end)
                                    <div class="fw-semibold text-dark">
                                        Coverage:
                                        <span class="text-muted">
                                            {{ \Carbon\Carbon::parse($maintenance->product->warranty_start)->format('d M Y') }}
                                            – {{ \Carbon\Carbon::parse($maintenance->product->warranty_end)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        Status: {{ $maintenance->product->warranty_status ?? 'Unknown' }}
                                    </small>
                                @else
                                    <span class="text-muted">No warranty info available</span>
                                @endif
                            </div>

                            {{-- ⏳ Urgency Badge --}}
                            @if($maintenance->product->warranty_start && $maintenance->product->warranty_end)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $end = \Carbon\Carbon::parse($maintenance->product->warranty_end);
                                    $expired = $end->isPast();

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

                                <span class="badge {{ $badgeClass }}" title="{{ $tooltip }}">
                                    {{ $badgeText }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- 📝 Issue Description --}}
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold text-primary">
                            <i class="fa fa-bug me-1"></i> Issue Description
                        </label>
                        <textarea name="description" id="description" rows="3" class="form-control"
                            required>{{ old('description', $maintenance->description) }}</textarea>
                    </div>

                    {{-- ⏱️ Start & End Time --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label fw-bold text-primary">
                                <i class="fa fa-play-circle me-1"></i> Start Time
                            </label>
                            <input type="datetime-local" name="start_time" id="start_time" class="form-control"
                                value="{{ old('start_time', optional($maintenance->start_time)->format('Y-m-d\TH:i')) }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label fw-bold text-primary">
                                <i class="fa fa-stop-circle me-1"></i> End Time
                            </label>
                            <input type="datetime-local" name="end_time" id="end_time" class="form-control"
                                value="{{ old('end_time', optional($maintenance->end_time)->format('Y-m-d\TH:i')) }}"
                                required>
                        </div>
                    </div>

                    {{-- 🎯 Action Buttons --}}
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-warning shadow-sm">
                            <i class="fa fa-save me-1"></i> Update Record
                        </button>
                        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="fa fa-arrow-left me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection