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
  <div class="charts-grid mb-4">
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

  <!-- Quick Actions & Alerts Row -->
  <div class="mb-4">
    <div class="row g-4">
      <!-- Quick Actions -->
      <div class="col-lg-4">
        <div class="dashboard-widget">
          <div class="widget-header">
            <div class="d-flex align-items-center">
              <div class="widget-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                <i class="bi bi-lightning"></i>
              </div>
              <div>
                <h5 class="widget-title">Quick Actions</h5>
                <small class="text-muted">Shortcuts</small>
              </div>
            </div>
          </div>
          <div class="widget-body">
            <div class="quick-actions-grid">
              @if(auth()->user()->permission <= 1)
              <a href="{{ route('products.create') }}" class="quick-action-item">
                <div class="action-icon-wrapper" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                  <i class="bi bi-plus-lg"></i>
                </div>
                <span>Add Product</span>
              </a>
              <a href="{{ route('categories.create') }}" class="quick-action-item">
                <div class="action-icon-wrapper" style="background: linear-gradient(135deg, #6366f1, #818cf8);">
                  <i class="bi bi-tag"></i>
                </div>
                <span>Category</span>
              </a>
              <a href="{{ route('brands.create') }}" class="quick-action-item">
                <div class="action-icon-wrapper" style="background: linear-gradient(135deg, #ec4899, #f472b6);">
                  <i class="bi bi-award"></i>
                </div>
                <span>Brand</span>
              </a>
              <a href="{{ route('users.create') }}" class="quick-action-item">
                <div class="action-icon-wrapper" style="background: linear-gradient(135deg, #10b981, #34d399);">
                  <i class="bi bi-person-plus"></i>
                </div>
                <span>Add User</span>
              </a>
              @endif
              <a href="{{ route('warranties.index') }}" class="quick-action-item">
                <div class="action-icon-wrapper" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                  <i class="bi bi-shield-check"></i>
                </div>
                <span>Warranties</span>
              </a>
              <a href="{{ route('maintenance.index') }}" class="quick-action-item">
                <div class="action-icon-wrapper" style="background: linear-gradient(135deg, #14b8a6, #5eead4);">
                  <i class="bi bi-tools"></i>
                </div>
                <span>Maintenance</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Alerts Widget -->
      <div class="col-lg-4">
        <div class="dashboard-widget">
          <div class="widget-header">
            <div class="d-flex align-items-center">
              <div class="widget-icon" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                <i class="bi bi-exclamation-triangle"></i>
              </div>
              <div>
                <h5 class="widget-title">Alerts</h5>
                <small class="text-muted">Notifications</small>
              </div>
            </div>
            @if($expiringWarranties->count() + $pendingMaintenance->count() > 0)
            <span class="badge-alert">{{ $expiringWarranties->count() + $pendingMaintenance->count() }}</span>
            @endif
          </div>
          <div class="widget-body">
            @if($expiringWarranties->count() > 0)
            <div class="alert-group">
              <h6 class="group-title"><i class="bi bi-clock me-1"></i>Expiring Warranties</h6>
              @foreach($expiringWarranties as $product)
              <a href="{{ route('products.show', $product->id) }}" class="alert-list-item">
                <div class="list-icon" style="background: #fef3c7;">
                  <i class="bi bi-shield-exclamation text-warning"></i>
                </div>
                <div class="list-content">
                  <span class="list-text">{{ $product->product_name }}</span>
                  <span class="list-meta">{{ $product->warranty_end->format('d M Y') }}</span>
                </div>
              </a>
              @endforeach
            </div>
            @endif

            @if($pendingMaintenance->count() > 0)
            <div class="alert-group">
              <h6 class="group-title"><i class="bi bi-tools me-1"></i>Ongoing Maintenance</h6>
              @foreach($pendingMaintenance as $m)
              <a href="{{ route('maintenance.show', $m->id) }}" class="alert-list-item">
                <div class="list-icon" style="background: #e0f2fe;">
                  <i class="bi bi-wrench text-info"></i>
                </div>
                <div class="list-content">
                  <span class="list-text">{{ $m->product->product_name ?? 'N/A' }}</span>
                  <span class="list-meta">{{ $m->end_time->format('d M Y') }}</span>
                </div>
              </a>
              @endforeach
            </div>
            @endif

            @if($expiringWarranties->count() == 0 && $pendingMaintenance->count() == 0)
            <div class="empty-state">
              <i class="bi bi-check-circle"></i>
              <span>All clear!</span>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Recent Products -->
      <div class="col-lg-4">
        <div class="dashboard-widget">
          <div class="widget-header">
            <div class="d-flex align-items-center">
              <div class="widget-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                <i class="bi bi-clock-history"></i>
              </div>
              <div>
                <h5 class="widget-title">Recent Products</h5>
                <small class="text-muted">Latest added</small>
              </div>
            </div>
          </div>
          <div class="widget-body">
            @forelse($recentProducts as $product)
            <a href="{{ route('products.show', $product->id) }}" class="recent-list-item">
              <div class="list-icon" style="background: #e0e7ff;">
                <i class="bi bi-box text-primary"></i>
              </div>
              <div class="list-content">
                <span class="list-text">{{ $product->product_name }}</span>
                <span class="list-meta">{{ $product->created_at->diffForHumans() }}</span>
              </div>
            </a>
            @empty
            <div class="empty-state">
              <i class="bi bi-inbox"></i>
              <span>No products yet</span>
            </div>
            @endforelse
            @if($recentProducts->count() > 0)
            <a href="{{ route('products.index') }}" class="widget-footer-link">View all products →</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Product Trend Chart -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="chart-card">
        <div class="chart-header">
          <h5 class="chart-title">
            <i class="bi bi-graph-up me-2"></i>Product Trend (Last 6 Months)
          </h5>
        </div>
        <div class="chart-body" style="height: 250px;">
          <canvas id="trendChart"></canvas>
        </div>
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

  /* Dashboard Widget */
  .dashboard-widget {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    border: 1px solid #f0f0f0;
    height: 100%;
    overflow: hidden;
  }

  .widget-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .widget-header > .d-flex {
    gap: 12px;
  }

  .widget-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .widget-icon i {
    font-size: 1.25rem;
    color: white;
  }

  .widget-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
  }

  .widget-header small {
    font-size: 0.75rem;
  }

  .badge-alert {
    background: #ef4444;
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .widget-body {
    padding: 16px 20px;
    max-height: 280px;
    overflow-y: auto;
  }

  /* Quick Actions */
  .quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
  }

  .quick-action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 14px 8px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.2s;
    background: #f9fafb;
    border: 1px solid transparent;
  }

  .quick-action-item:hover {
    background: #f3f4f6;
    transform: translateY(-2px);
    border-color: #e5e7eb;
  }

  .action-icon-wrapper {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
  }

  .quick-action-item span {
    font-size: 0.7rem;
    font-weight: 500;
    color: #6b7280;
    text-align: center;
    line-height: 1.2;
  }

  /* Alert List */
  .alert-group {
    margin-bottom: 16px;
  }

  .alert-group:last-child {
    margin-bottom: 0;
  }

  .group-title {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .alert-list-item, .recent-list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 8px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
    margin-bottom: 6px;
  }

  .alert-list-item:hover, .recent-list-item:hover {
    background: #f9fafb;
  }

  .list-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .list-icon i {
    font-size: 1rem;
  }

  .list-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
  }

  .list-text {
    font-size: 0.85rem;
    color: #1f2937;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .list-meta {
    font-size: 0.7rem;
    color: #9ca3af;
  }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 30px 20px;
    color: #9ca3af;
  }

  .empty-state i {
    font-size: 2rem;
    margin-bottom: 8px;
    color: #10b981;
  }

  .empty-state span {
    font-size: 0.85rem;
  }

  .widget-footer-link {
    display: block;
    text-align: center;
    padding: 10px;
    margin-top: 8px;
    color: #6366f1;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    border-top: 1px solid #f0f0f0;
  }

  .widget-footer-link:hover {
    color: #4f46e5;
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
    
    .quick-actions-grid {
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

  // Product Trend Chart
  new Chart(document.getElementById('trendChart').getContext('2d'), {
    type: 'line',
    data: {
      labels: {!! json_encode(array_column($productTrend, 'month')) !!},
      datasets: [{
        label: 'Products Added',
        data: {!! json_encode(array_column($productTrend, 'count')) !!},
        borderColor: '#6366f1',
        backgroundColor: 'rgba(99, 102, 241, 0.1)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#6366f1',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6
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
          cornerRadius: 8,
          callbacks: {
            label: ctx => `${ctx.raw} products added`
          }
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
