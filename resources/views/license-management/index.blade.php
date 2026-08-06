@extends('layouts.app')

@section('title', 'License Management')

@section('contents')
<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h5 class="mb-0 fw-bold"><i class="bi bi-key-fill me-2 text-primary"></i>License Management</h5>
                <small class="text-muted">Administrative tools for managing this installation's license.</small>
            </div>
        </div>
    </div>
</div>

@if(!$info['cache_exists'])
<div class="alert alert-secondary">
    <i class="bi bi-info-circle me-2"></i>
    No local license cache was found on this system. The application is not licensed yet.
    @if(!$info['installed'])
        Please complete the installation wizard first.
    @endif
</div>
@endif

<div class="row g-4">
    {{-- Status card --}}
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-shield-check me-2 text-primary"></i>Current License Status</h6>
            </div>
            <div class="card-body">
                @php
                    $status = $info['status'] ?? null;
                    $badge = [
                        'active'   => ['bg-success', 'Active'],
                        'revoked'  => ['bg-danger',  'Revoked'],
                        'expired'  => ['bg-warning text-dark', 'Expired'],
                        'inactive' => ['bg-secondary', 'Inactive'],
                        'suspended'=> ['bg-purple', 'Suspended'],
                    ];
                @endphp
                @if(!$info['cache_exists'])
                    <span class="badge bg-secondary fs-6">Not installed</span>
                    <p class="text-muted small mt-3 mb-0">No license cache present on this machine.</p>
                @elseif(isset($badge[$status]))
                    <span class="badge {{ $badge[$status][0] }} fs-6">{{ $badge[$status][1] }}</span>
                    @if($status === 'revoked')
                        <p class="text-danger small mt-3 mb-0">
                            This license has been revoked. The dashboard is locked. Use the actions below to reactivate it
                            or apply a replacement license.
                        </p>
                    @elseif($status === 'expired')
                        <p class="text-warning small mt-3 mb-0">
                            This license has expired. Apply a replacement license to continue.
                        </p>
                    @elseif($status === 'active')
                        <p class="text-success small mt-3 mb-0">This license is active and valid.</p>
                    @else
                        <p class="text-muted small mt-3 mb-0">This license is not active. Contact your software provider.</p>
                    @endif
                @else
                    <span class="badge bg-danger fs-6">Unable to verify</span>
                    <p class="text-muted small mt-3 mb-0">Local cache is present but its status could not be determined.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Details card --}}
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>License Details</h6>
            </div>
            <div class="card-body">
                @if($info['cache_exists'])
                    <div class="row g-3">
                        <div class="col-md-6">
                            <span class="text-muted small d-block">License Key</span>
                            <span class="fw-semibold" id="license-key-display">{{ $info['masked_key'] ?: '—' }}</span>
                            @if($info['license_key'])
                                <button type="button" class="btn btn-sm btn-link p-0 ms-2"
                                    id="toggle-key-btn"
                                    data-full-key="{{ $info['license_key'] }}"
                                    data-masked-key="{{ $info['masked_key'] }}"
                                    onclick="toggleLicenseKey()" title="Show / hide full key">
                                    <i class="bi bi-eye"></i>
                                </button>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">Domain (site_url)</span>
                            <span class="fw-semibold">{{ $info['site_url'] ?: '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">Machine ID</span>
                            <span class="fw-semibold" style="font-family:monospace;font-size:0.85rem;word-break:break-all;">{{ $info['machine_id'] ?: '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">Product ID</span>
                            <span class="fw-semibold">{{ $info['product_id'] }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">Expires At</span>
                            <span class="fw-semibold">
                                {{ $info['expires_at'] ? \Carbon\Carbon::parse($info['expires_at'])->format('M d, Y H:i') : '—' }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">Last Checked</span>
                            <span class="fw-semibold">
                                {{ $info['last_check'] ? \Carbon\Carbon::parse($info['last_check'])->format('M d, Y H:i') : '—' }}
                            </span>
                        </div>
                        <div class="col-12">
                            <span class="text-muted small d-block">License Server</span>
                            <span class="fw-semibold" style="word-break:break-all;">{{ $info['server_url'] }}</span>
                            @if(!$info['api_key_configured'])
                                <span class="badge bg-warning text-dark ms-2">API key not configured</span>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-muted mb-0">No license details available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Admin actions --}}
@if($info['cache_exists'])
<div class="row g-4 mt-1">
    {{-- Reactivate --}}
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-arrow-clockwise me-2 text-success"> </i>Reactivate This License</h6>
            </div>
            <div class="card-body">
                @if($status === 'revoked')
                    <p class="text-muted small">
                        Contact the license server to reactivate this exact license key. The server must allow reactivation
                        (<code>LICENSE_ALLOW_REACTIVATION=true</code>) and the request must come from the machine this
                        license is bound to. Clearing the local cache alone will <strong>not</strong> activate a revoked
                        license.
                    </p>
                    <form method="POST" action="{{ route('license-management.reactivate') }}"
                        onsubmit="return confirm('Contact the license server to reactivate this revoked license?')">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reactivate License
                        </button>
                    </form>
                @elseif($status === 'active')
                    <p class="text-muted small mb-0">This license is already active. Reactivation is only available for revoked licenses.</p>
                @else
                    <p class="text-muted small mb-0">
                        This license is not revoked, so it cannot be reactivated. Use the replacement form below if you need a new key.
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Replace + Refresh --}}
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-key me-2 text-primary"></i>Apply Replacement License</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Enter a replacement license key issued by your license provider (created on the license server
                    dashboard). The new key is activated with the license server and replaces the current local cache.
                </p>
                <form method="POST" action="{{ route('license-management.replace') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="replacement_license_key" class="form-control"
                            placeholder="XXXX-XXXX-XXXX-XXXX" required
                            style="letter-spacing:1px; font-weight:600;" autocomplete="off">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Apply
                        </button>
                    </div>
                    @error('replacement_license_key')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h6 class="mb-1 fw-bold"><i class="bi bi-arrow-repeat me-2 text-primary"></i>Refresh Local License Cache</h6>
                    <p class="text-muted small mb-0">
                        Re-checks the license status with the license server and re-saves the authoritative status locally.
                        A revoked or expired license stays locked — refreshing never activates a license on its own.
                    </p>
                </div>
                <form method="POST" action="{{ route('license-management.refresh') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-repeat me-1"></i> Check &amp; Refresh
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Security notes --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-light border">
            <h6 class="fw-bold"><i class="bi bi-shield-lock me-2 text-primary"></i>Security Notes</h6>
            <ul class="small text-muted mb-0">
                <li>Only administrators (Admin / Super Admin) can access this page and perform these actions. All actions are logged.</li>
                <li>The license server is authoritative. Clearing or refreshing the local cache never activates a revoked license.</li>
                <li>Reactivation is only possible if the license server allows it and the request matches the bound machine.</li>
                <li>If reactivation is not possible, use the replacement form with a key issued from the license server dashboard.</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let licenseKeyVisible = false;
    const toggleBtn = document.getElementById('toggle-key-btn');
    const displayEl = document.getElementById('license-key-display');

    function toggleLicenseKey() {
        licenseKeyVisible = !licenseKeyVisible;
        const fullKey = toggleBtn ? toggleBtn.dataset.fullKey : '';
        const maskedKey = toggleBtn ? toggleBtn.dataset.maskedKey : '';
        displayEl.textContent = licenseKeyVisible ? fullKey : maskedKey;
    }
</script>
@endsection
