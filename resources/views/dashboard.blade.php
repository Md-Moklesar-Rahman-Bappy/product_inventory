@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')
<div class="row">
  <div class="col-md-12">

    <!-- Welcome Card -->
    <div class="custom-card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-person-waving me-2"></i>Welcome, {{ auth()->user()->name }}</h5>
        <span class="badge bg-primary fw-semibold">
          Product Inventory System
        </span>
      </div>
      <div class="card-body">
        <p class="mb-2">
          This is your central hub for managing <strong>categories</strong>, <strong>brands</strong>, <strong>models</strong>, and <strong>products</strong> with clarity and control.
        </p>
        <p class="text-muted small mb-3">
          Use the sidebar to navigate between modules. All changes are reflected <span class="text-success fw-semibold">in real-time</span> for seamless updates.
        </p>
        <div class="d-flex gap-2 flex-wrap">
          <span class="badge bg-success text-white fw-medium">Modular</span>
          <span class="badge bg-warning text-dark fw-medium">Maintainable</span>
          <span class="badge bg-secondary text-white fw-medium">Joyful UI</span>
        </div>
      </div>
    </div>

    <!-- Summary Cards -->
    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
      @foreach($entityCounts as $label => $count)
        @php
          $routeMap = [
            'Categories' => 'categories.index',
            'Brands' => 'brands.index',
            'Models' => 'models.index',
            'Products' => 'products.index',
            'Maintenance' => 'maintenance.index',
            'Warranty' => 'warranties.index',
          ];
          $iconMap = [
            'Categories' => 'bi-tags',
            'Brands' => 'bi-award',
            'Models' => 'bi-layers',
            'Products' => 'bi-box',
            'Maintenance' => 'bi-tools',
            'Warranty' => 'bi-shield-check',
          ];
          $route = $routeMap[$label] ?? '#';
          $icon = $iconMap[$label] ?? 'bi-box';
        @endphp

        <a href="{{ route($route) }}" class="text-decoration-none" title="View all {{ strtolower($label) }}">
          <div class="custom-card text-center px-3 py-2" style="min-width: 120px;">
            <div class="card-body p-2">
              <i class="bi {{ $icon }} text-primary mb-1" style="font-size: 1.4rem;"></i>
              <h6 class="fw-bold text-dark mb-0">{{ $count }}</h6>
              <small class="text-muted">{{ $label }}</small>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    <!-- Charts Row -->
    <div class="row">
      <!-- Entity Distribution Chart -->
      <div class="col-md-6 mb-4">
        <div class="custom-card h-100">
          <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-pie-chart me-2"></i>Entity Distribution</h5>
            <select id="chartTypeSelector" class="form-select form-select-sm w-auto" onchange="switchChartType(this.value)">
              <option value="pie">Pie</option>
              <option value="doughnut">Doughnut</option>
              <option value="polarArea">Polar Area</option>
            </select>
          </div>
          <div class="card-body text-center">
            <div class="mx-auto" style="max-width: 360px;">
              <canvas id="entityChart" width="300" height="300" style="max-width: 100%; height: auto;"></canvas>
            </div>
            <div class="d-flex gap-2 flex-wrap justify-content-center mt-4">
              @foreach($entityCounts as $label => $count)
                <span class="badge bg-light text-dark fw-medium">
                  {{ $label }}: <strong>{{ $count }}</strong>
                </span>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <!-- Warranty Status Chart -->
      <div class="col-md-6 mb-4">
        <div class="custom-card h-100">
          <div class="card-header">
            <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-shield-check me-2"></i>Warranty Status Overview</h5>
          </div>
          <div class="card-body text-center">
            <div class="mx-auto" style="max-width: 500px;">
              <canvas id="warrantyChart" width="400" height="300" style="max-width: 100%; height: auto;"></canvas>
            </div>
            <div class="d-flex gap-2 flex-wrap justify-content-center mt-4">
              @foreach($warrantyBreakdown as $status => $count)
                @php
                  $colorMap = [
                    'Active' => 'bg-success text-white',
                    'Expiring Soon' => 'bg-warning text-dark',
                    'Expired' => 'bg-danger text-white',
                  ];
                  $badgeClass = $colorMap[$status] ?? 'bg-light text-dark';
                @endphp
                <span class="badge {{ $badgeClass }} fw-medium">
                  {{ $status }}: <strong>{{ $count }}</strong>
                </span>
              @endforeach
            </div>
            @if(array_sum($warrantyBreakdown) === 0)
              <div class="text-muted mt-3">No warranty data available.</div>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<style>
  .custom-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .custom-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  canvas {
    transition: transform 0.3s ease;
  }
  canvas:hover {
    transform: scale(1.02);
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Entity Chart
  let currentType = 'pie';
  let entityChart;
  const entityCtx = document.getElementById('entityChart').getContext('2d');

  function renderEntityChart(type) {
    entityChart = new Chart(entityCtx, {
      type: type,
      data: {
        labels: {!! json_encode(array_keys($entityCounts)) !!},
        datasets: [{
          data: {!! json_encode(array_values($entityCounts)) !!},
          backgroundColor: ['#0d6efd', '#6610f2', '#6f42c1', '#198754', '#ffc107', '#dc3545'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { animateScale: true, duration: 1000 },
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 12, padding: 15 }
          },
          tooltip: {
            callbacks: {
              label: ctx => `${ctx.label}: ${ctx.raw} items`
            }
          }
        }
      }
    });
  }

  function switchChartType(type) {
    entityChart.destroy();
    currentType = type;
    renderEntityChart(currentType);
  }

  renderEntityChart(currentType);

  // Warranty Chart
    const warrantyCtx = document.getElementById('warrantyChart').getContext('2d');
  new Chart(warrantyCtx, {
    type: 'bar',
    data: {
      labels: ['Active', 'Expiring Soon', 'Expired'],
      datasets: [{
        label: 'Warranty Count',
        data: [
          {{ $warrantyBreakdown['Active'] ?? 0 }},
          {{ $warrantyBreakdown['Expiring Soon'] ?? 0 }},
          {{ $warrantyBreakdown['Expired'] ?? 0 }}
        ],
        backgroundColor: ['#198754', '#ffc107', '#dc3545'],
        borderRadius: 5,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: {
        duration: 800,
        easing: 'easeOutQuart'
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(ctx) {
              return `${ctx.label}: ${ctx.raw} warranties`;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            font: { size: 12 }
          },
          grid: { color: '#f0f0f0' }
        },
        x: {
          ticks: { font: { size: 12 } },
          grid: { display: false }
        }
      }
    }
  });
</script>
@endpush
