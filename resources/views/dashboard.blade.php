@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')
<div class="dashboard-container">
  <!-- Welcome Section -->
  <div class="welcome-section mb-4">
    <div class="welcome-content">
      <div class="welcome-text">
        <h4 class="welcome-title">Welcome back, {{ auth()->user()->name }}! 👋</h4>
        <p class="welcome-subtitle">Here's what's happening with your inventory today.</p>
      </div>
      <div class="welcome-badge">
        <span class="badge-modern">
          <i class="bi bi-box-seam me-2"></i>Product Inventory System
        </span>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="stats-grid">
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
          'Categories' => 'bi-tag',
          'Brands' => 'bi-award',
          'Models' => 'bi-layers',
          'Products' => 'bi-box',
          'Maintenance' => 'bi-tools',
          'Warranty' => 'bi-shield-check',
        ];
        $colorMap = [
          'Categories' => ['#6366f1', '#818cf8'],
          'Brands' => ['#ec4899', '#f472b6'],
          'Models' => ['#14b8a6', '#5eead4'],
          'Products' => ['#3b82f6', '#60a5fa'],
          'Maintenance' => ['#f59e0b', '#fbbf24'],
          'Warranty' => ['#10b981', '#34d399'],
        ];
        $route = $routeMap[$label] ?? '#';
        $icon = $iconMap[$label] ?? 'bi-box';
        $colors = $colorMap[$label] ?? ['#6366f1', '#818cf8'];
      @endphp

      <a href="{{ route($route) }}" class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, {{ $colors[0] }}, {{ $colors[1] }});">
          <i class="bi {{ $icon }}"></i>
        </div>
        <div class="stat-info">
          <span class="stat-value">{{ $count }}</span>
          <span class="stat-label">{{ $label }}</span>
        </div>
      </a>
    @endforeach
  </div>

  <!-- Charts Section -->
  <div class="charts-grid">
    <!-- Entity Distribution -->
    <div class="chart-card">
      <div class="chart-header">
        <h5 class="chart-title">
          <i class="bi bi-pie-chart me-2"></i>Entity Distribution
        </h5>
        <select id="chartTypeSelector" class="chart-select" onchange="switchChartType(this.value)">
          <option value="pie">Pie</option>
          <option value="doughnut">Doughnut</option>
          <option value="polarArea">Polar</option>
        </select>
      </div>
      <div class="chart-body">
        <canvas id="entityChart"></canvas>
      </div>
      <div class="chart-legend">
        @foreach($entityCounts as $label => $count)
          @php
            $colorMap = [
              'Categories' => '#6366f1',
              'Brands' => '#ec4899',
              'Models' => '#14b8a6',
              'Products' => '#3b82f6',
              'Maintenance' => '#f59e0b',
              'Warranty' => '#10b981',
            ];
          @endphp
          <span class="legend-item">
            <span class="legend-dot" style="background: {{ $colorMap[$label] ?? '#6366f1' }}"></span>
            {{ $label }}
          </span>
        @endforeach
      </div>
    </div>

    <!-- Warranty Status -->
    <div class="chart-card">
      <div class="chart-header">
        <h5 class="chart-title">
          <i class="bi bi-shield-check me-2"></i>Warranty Status
        </h5>
      </div>
      <div class="chart-body">
        <canvas id="warrantyChart"></canvas>
      </div>
      <div class="warranty-legend">
        <span class="legend-item">
          <span class="legend-dot" style="background: #10b981"></span>
          Active
        </span>
        <span class="legend-item">
          <span class="legend-dot" style="background: #f59e0b"></span>
          Expiring Soon
        </span>
        <span class="legend-item">
          <span class="legend-dot" style="background: #ef4444"></span>
          Expired
        </span>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .dashboard-container {
    padding: 0;
  }

  .welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    color: white;
  }

  .welcome-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }

  .welcome-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 4px;
  }

  .welcome-subtitle {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
  }

  .badge-modern {
    background: rgba(255,255,255,0.2);
    padding: 10px 20px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
  }

  .stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
  }

  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
  }

  .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .stat-icon i {
    font-size: 1.5rem;
    color: white;
  }

  .stat-info {
    display: flex;
    flex-direction: column;
  }

  .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.2;
  }

  .stat-label {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
  }

  .charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 24px;
  }

  .chart-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    border: 1px solid #f0f0f0;
  }

  .chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .chart-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
  }

  .chart-select {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    font-size: 0.85rem;
    color: #6b7280;
    background: #f9fafb;
    cursor: pointer;
    outline: none;
  }

  .chart-select:focus {
    border-color: #6366f1;
  }

  .chart-body {
    position: relative;
    height: 280px;
  }

  .chart-legend, .warranty-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #f0f0f0;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    color: #6b7280;
  }

  .legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
  }

  @media (max-width: 768px) {
    .charts-grid {
      grid-template-columns: 1fr;
    }
    
    .welcome-content {
      flex-direction: column;
      text-align: center;
    }
    
    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const entityColors = ['#6366f1', '#ec4899', '#14b8a6', '#3b82f6', '#f59e0b', '#10b981'];
  
  let entityChart;
  const entityCtx = document.getElementById('entityChart').getContext('2d');

  function renderEntityChart(type) {
    entityChart = new Chart(entityCtx, {
      type: type,
      data: {
        labels: {!! json_encode(array_keys($entityCounts)) !!},
        datasets: [{
          data: {!! json_encode(array_values($entityCounts)) !!},
          backgroundColor: entityColors,
          borderWidth: 0,
          hoverOffset: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: type === 'doughnut' ? '55%' : '0%',
        animation: { animateScale: true, duration: 1000 },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#1f2937',
            padding: 12,
            cornerRadius: 8,
            titleFont: { size: 14, weight: '600' },
            bodyFont: { size: 13 },
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
    renderEntityChart(type);
  }

  renderEntityChart('doughnut');

  new Chart(document.getElementById('warrantyChart').getContext('2d'), {
    type: 'bar',
    data: {
      labels: ['Active', 'Expiring Soon', 'Expired'],
      datasets: [{
        data: [
          {{ $warrantyBreakdown['Active'] ?? 0 }},
          {{ $warrantyBreakdown['Expiring Soon'] ?? 0 }},
          {{ $warrantyBreakdown['Expired'] ?? 0 }}
        ],
        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
        borderRadius: 8,
        borderSkipped: false,
        barThickness: 40
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1f2937',
          padding: 12,
          cornerRadius: 8
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: '#f3f4f6' },
          ticks: { stepSize: 1, color: '#9ca3af' }
        },
        x: {
          grid: { display: false },
          ticks: { color: '#6b7280', font: { weight: '500' } }
        }
      }
    }
  });
</script>
@endpush
