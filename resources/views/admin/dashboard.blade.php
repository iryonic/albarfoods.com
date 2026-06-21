@extends('layouts.admin')

@section('title', 'Admin Dashboard - Al Barr')
@section('header_title', 'Administrative Overview')

@section('styles')
<style>
    /* Metric Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .kpi-card {
        background-color: var(--color-admin-card-bg);
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: var(--shadow-admin-sm);
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: transparent;
        transition: var(--transition-smooth);
        border-radius: var(--radius-admin-card) var(--radius-admin-card) 0 0;
    }

    .kpi-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-admin-lg); border-color: rgba(197, 168, 128, 0.35); }
    
    .kpi-card.revenue-card:hover::before { background: linear-gradient(90deg, var(--color-admin-gold) 0%, #018849 100%); }
    .kpi-card.orders-card:hover::before { background: #018849; }
    .kpi-card.aov-card:hover::before { background: #3b82f6; }
    .kpi-card.customers-card:hover::before { background: #ec4899; }

    .kpi-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }

    .kpi-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .kpi-icon.revenue { background-color: rgba(197, 168, 128, 0.1); color: var(--color-admin-gold); border: 1px solid rgba(197, 168, 128, 0.15); }
    .kpi-icon.orders  { background-color: rgba(1, 136, 73, 0.08); color: var(--color-admin-accent); border: 1px solid rgba(1, 136, 73, 0.15); }
    .kpi-icon.aov     { background-color: rgba(59, 130, 246, 0.08); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.15); }
    .kpi-icon.customers { background-color: rgba(236, 72, 153, 0.08); color: #ec4899; border: 1px solid rgba(236, 72, 153, 0.15); }

    .kpi-label { font-size: 0.74rem; color: var(--color-admin-text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; }
    .kpi-val { font-family: var(--font-secondary); font-size: 1.75rem; font-weight: 900; color: var(--color-admin-text-main); margin: 0; letter-spacing: -0.5px; }
    .kpi-trend { font-size: 0.76rem; font-weight: 700; display: flex; align-items: center; gap: 6px; margin-top: 10px; }
    .kpi-trend.up { color: var(--color-admin-accent); }

    /* Charts Row */
    .charts-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .chart-card {
        background-color: var(--color-admin-card-bg);
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 22px;
        box-shadow: var(--shadow-admin-sm);
        transition: var(--transition-smooth);
    }

    .chart-card:hover { box-shadow: var(--shadow-admin-lg); border-color: rgba(197, 168, 128, 0.35); }

    .chart-container { position: relative; height: 290px; width: 100%; margin-top: 16px; }

    /* Dashboard Details Grid */
    .dashboard-details-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 20px;
    }

    .details-table-wrap { overflow-x: auto; }

    /* Stock Alerts */
    .stock-alerts-list { display: flex; flex-direction: column; gap: 10px; }

    .stock-alert-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background-color: #fffaf9;
        border: 1px solid #fdebe7;
        border-radius: 10px;
        transition: var(--transition-fast);
    }

    .stock-alert-item:hover { border-color: #f9d0c4; transform: translateX(3px); }

    .stock-qty-badge {
        background-color: #ba3c1c;
        color: #fff;
        font-family: var(--font-mono);
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.76rem;
        flex-shrink: 0;
    }

    /* Timeline */
    .timeline-container {
        position: relative;
        padding-left: 20px;
        margin-left: 10px;
        border-left: 2px solid var(--color-admin-border);
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .timeline-item { position: relative; font-size: 0.86rem; }

    .timeline-dot {
        position: absolute;
        left: -27px; top: 4px;
        width: 12px; height: 12px;
        border-radius: 50%;
        background-color: var(--color-admin-border);
        border: 3px solid #fff;
        box-shadow: var(--shadow-admin-sm);
    }

    .timeline-dot.stock-in  { background-color: var(--color-admin-accent); box-shadow: 0 0 0 3px rgba(1, 136, 73, 0.15); }
    .timeline-dot.stock-out { background-color: #ba3c1c; box-shadow: 0 0 0 3px rgba(186, 60, 28, 0.15); }

    .timeline-time { font-size: 0.72rem; color: var(--color-admin-text-muted); font-weight: 700; display: block; margin-bottom: 2px; text-transform: uppercase; letter-spacing: 0.4px; }
    .timeline-content { color: var(--color-admin-text-main); line-height: 1.4; }

    @media (max-width: 1200px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .charts-grid { grid-template-columns: 1fr; }
        .dashboard-details-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 580px) {
        .kpi-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- Metric Cards -->
<section class="kpi-grid">
    <!-- Revenue -->
    <div class="kpi-card revenue-card">
        <div class="kpi-card-top">
            <span class="kpi-label">Revenue</span>
            <div class="kpi-icon revenue">₹</div>
        </div>
        <span class="kpi-val">₹{{ number_format($totalRevenue, 2) }}</span>
        <div class="kpi-trend up">
            <span>▲ 14.8%</span>
            <span style="color: var(--color-admin-text-muted); font-weight: normal;">vs last month</span>
        </div>
    </div>
    
    <!-- Orders -->
    <div class="kpi-card orders-card">
        <div class="kpi-card-top">
            <span class="kpi-label">Orders placed</span>
            <div class="kpi-icon orders">🛒</div>
        </div>
        <span class="kpi-val">{{ $totalOrders }}</span>
        <div class="kpi-trend up">
            <span>▲ 8.2%</span>
            <span style="color: var(--color-admin-text-muted); font-weight: normal;">vs last month</span>
        </div>
    </div>
    
    <!-- AOV -->
    <div class="kpi-card aov-card">
        <div class="kpi-card-top">
            <span class="kpi-label">Avg Order Value</span>
            <div class="kpi-icon aov">📈</div>
        </div>
        <span class="kpi-val">₹{{ number_format($averageOrderValue, 2) }}</span>
        <div class="kpi-trend up" style="color: var(--color-admin-accent);">
            <span>▲ 6.1%</span>
            <span style="color: var(--color-admin-text-muted); font-weight: normal;">vs last month</span>
        </div>
    </div>
    
    <!-- Customers -->
    <div class="kpi-card customers-card">
        <div class="kpi-card-top">
            <span class="kpi-label">Customers</span>
            <div class="kpi-icon customers">👥</div>
        </div>
        <span class="kpi-val">{{ $totalCustomers }}</span>
        <div class="kpi-trend up">
            <span>▲ 11.2%</span>
            <span style="color: var(--color-admin-text-muted); font-weight: normal;">vs last month</span>
        </div>
    </div>
</section>

<!-- Charts Section -->
<section class="charts-grid">
    <!-- Left Chart: Revenue Trends / Sales -->
    <div class="chart-card">
        <div class="admin-card-title">
            <span>📈 Sales Revenue Trends</span>
            <select id="chartPeriodSelect" class="admin-select" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 6px; width: auto; font-weight: 700; border-color: var(--color-admin-border);">
                <option value="daily">Daily Sales (Last 7 Days)</option>
                <option value="monthly">Monthly Sales (Current Year)</option>
            </select>
        </div>
        <div class="chart-container">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>

    <!-- Right Chart: Category Breakdown -->
    <div class="chart-card">
        <h2 class="admin-card-title">🌾 Category Sourcing Share</h2>
        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</section>

<!-- Details / Lists Section -->
<section class="dashboard-details-grid">
    
    <!-- Recent Orders List -->
    <div class="admin-card">
        <h2 class="admin-card-title">
            <span>🛒 Recent Orders Registry</span>
            <a href="{{ route('admin.orders') }}" class="btn-action-outline">View All →</a>
        </h2>
        <div class="details-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><strong style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-admin-accent)">{{ $order->order_number }}</strong></td>
                            <td style="font-weight: 700;">{{ $order->shipping_name }}</td>
                            <td style="font-weight: 800;">₹{{ number_format($order->grand_total, 2) }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td style="color: var(--color-admin-text-muted); font-size: 0.82rem; font-weight: 500;">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--color-admin-text-muted); padding: 40px;">No orders registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory Logs & Alerts -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Low Stock Alerts -->
        <div class="admin-card" style="margin-bottom: 0;">
            <h2 class="admin-card-title">
                <span>⚠️ Low Stock Alerts</span>
                <span class="status-badge cancelled" style="font-size: 0.68rem; padding: 2px 8px;">&lt;= 10 units</span>
            </h2>
            <div class="stock-alerts-list">
                @forelse($lowStockVariants as $variant)
                    <div class="stock-alert-item">
                        <div style="display: flex; flex-direction: column; gap: 2px;">
                            <span style="font-weight: 700; font-size: 0.88rem; color: var(--color-admin-text-main);">{{ $variant->product->title }}</span>
                            <span style="font-size: 0.76rem; color: var(--color-admin-text-muted);">SKU: <strong style="font-family: var(--font-mono);">{{ $variant->sku }}</strong> &bull; Size: {{ $variant->weight }}</span>
                        </div>
                        <span class="stock-qty-badge">{{ $variant->stock }} left</span>
                    </div>
                @empty
                    <div style="text-align: center; padding: 30px; color: var(--color-admin-accent); font-weight: 700; border: 1px dashed rgba(1, 136, 73, 0.2); border-radius:12px;">
                        🎉 All catalog variants are fully stocked!
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent activities timeline -->
        <div class="admin-card" style="margin-bottom: 0;">
            <h2 class="admin-card-title">🪵 Recent Inventory Log</h2>
            <div class="timeline-container">
                @forelse($recentActivities as $log)
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $log->quantity_change > 0 ? 'stock-in' : 'stock-out' }}"></div>
                        <span class="timeline-time">{{ $log->created_at->diffForHumans() }}</span>
                        <div class="timeline-content">
                            <strong style="color: var(--color-admin-text-main)">{{ $log->type }}</strong> &bull; 
                            <strong style="color: {{ $log->quantity_change > 0 ? 'var(--color-admin-accent)' : '#ba3c1c' }}">{{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }} units</strong>
                            for {{ $log->variant->product->title ?? 'Deleted Product' }} ({{ $log->variant->weight ?? 'N/A' }})
                            <span style="display: block; font-size: 0.78rem; color: var(--color-admin-text-muted); margin-top: 3px; font-style: italic;">"{{ $log->log_message }}"</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 30px; color: var(--color-admin-text-muted);">
                        No inventory adjustments logged.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Daily Sales labels & data
        const dailyLabels = {!! json_encode(array_keys($dailySalesData)) !!};
        const dailyData = {!! json_encode(array_values($dailySalesData)) !!};

        // Monthly Sales labels & data
        const monthlyLabels = {!! json_encode(array_keys($monthlySalesData)) !!};
        const monthlyData = {!! json_encode(array_values($monthlySalesData)) !!};

        // Initialize Trend Chart
        const ctxSales = document.getElementById('salesTrendChart').getContext('2d');
        
        // Create Gradient
        const gradientGold = ctxSales.createLinearGradient(0, 0, 0, 300);
        gradientGold.addColorStop(0, 'rgba(197, 168, 128, 0.4)');
        gradientGold.addColorStop(1, 'rgba(197, 168, 128, 0.01)');

        let currentChartData = {
            labels: dailyLabels,
            datasets: [{
                label: 'Sales Revenue',
                data: dailyData,
                backgroundColor: gradientGold,
                borderColor: '#c5a880',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#c5a880',
                pointBorderColor: '#fff',
                pointHoverRadius: 7
            }]
        };

        const salesChart = new Chart(ctxSales, {
            type: 'line',
            data: currentChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6d7175', font: { family: 'Plus Jakarta Sans', weight: '600' } }
                    },
                    y: {
                        grid: { color: '#f1f2f4' },
                        ticks: {
                            color: '#6d7175',
                            font: { family: 'Plus Jakarta Sans', weight: '600' },
                            callback: function(value) { return '₹' + value.toLocaleString('en-IN'); }
                        }
                    }
                }
            }
        });

        // Event listener to toggle period charts
        document.getElementById('chartPeriodSelect').addEventListener('change', function() {
            if (this.value === 'daily') {
                salesChart.data.labels = dailyLabels;
                salesChart.data.datasets[0].data = dailyData;
            } else {
                salesChart.data.labels = monthlyLabels;
                salesChart.data.datasets[0].data = monthlyData;
            }
            salesChart.update();
        });

        // Initialize Categories Chart
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        const catNames = {!! json_encode(collect($topCategories)->pluck('name')) !!};
        const catQty = {!! json_encode(collect($topCategories)->pluck('total_qty')) !!};

        const categoryChart = new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: catNames.length > 0 ? catNames : ['Dry Fruits', 'Honey', 'Spices'],
                datasets: [{
                    data: catQty.length > 0 ? catQty : [30, 20, 15],
                    backgroundColor: [
                        '#018849', // Green
                        '#c5a880', // Gold
                        '#BA0C2F', // Red
                        '#0B192C', // Dark Blue
                        '#718096'  // Slate
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#202223',
                            font: { family: 'Plus Jakarta Sans', weight: '700', size: 12 },
                            padding: 16
                        }
                    }
                },
                cutout: '72%'
            }
        });
    });
</script>
@endsection
