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
        margin-bottom: var(--spacing-xl);
    }

    .kpi-card {
        background-color: var(--color-admin-card-bg);
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 24px var(--spacing-lg);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: var(--shadow-admin-sm);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-admin-md);
        border-color: var(--color-admin-gold);
    }

    .kpi-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .kpi-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .kpi-icon.revenue {
        background-color: rgba(197, 168, 128, 0.1);
        color: var(--color-admin-gold);
    }

    .kpi-icon.orders {
        background-color: rgba(1, 136, 73, 0.1);
        color: var(--color-admin-accent);
    }

    .kpi-icon.aov {
        background-color: rgba(11, 25, 44, 0.05);
        color: var(--color-admin-sidebar);
    }

    .kpi-icon.customers {
        background-color: rgba(186, 12, 47, 0.08);
        color: #ba0c2f;
    }

    .kpi-label {
        font-size: 0.85rem;
        color: var(--color-admin-text-muted);
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .kpi-val {
        font-family: var(--font-secondary);
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--color-admin-text-main);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .kpi-trend {
        font-size: 0.76rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
    }
    
    .kpi-trend.up {
        color: var(--color-admin-accent);
    }

    /* Charts Row */
    .charts-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
        margin-bottom: var(--spacing-xl);
    }

    .chart-card {
        background-color: var(--color-admin-card-bg);
        border: 1px solid var(--color-admin-border);
        border-radius: var(--radius-admin-card);
        padding: 24px;
        box-shadow: var(--shadow-admin-sm);
        transition: box-shadow 0.2s;
    }

    .chart-card:hover {
        box-shadow: var(--shadow-admin-md);
    }

    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
        margin-top: 15px;
    }

    /* Double Column Lists Layout */
    .dashboard-details-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 24px;
    }

    .details-table-wrap {
        overflow-x: auto;
        margin: 0 -20px;
        padding: 0 20px;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-table th {
        padding: 14px 12px;
        border-bottom: 2px solid var(--color-admin-border-light);
        font-weight: 700;
        font-size: 0.82rem;
        color: var(--color-admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .admin-table td {
        padding: 16px 12px;
        border-bottom: 1px solid var(--color-admin-border-light);
        font-size: 0.9rem;
        vertical-align: middle;
        color: var(--color-admin-text-main);
    }

    .admin-table tr:hover td {
        background-color: #fafbfc;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    /* Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 0.74rem;
        font-weight: 700;
        text-transform: capitalize;
        gap: 4px;
    }

    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-badge.pending {
        background-color: #fff4e5;
        color: #b36200;
    }
    .status-badge.pending::before {
        background-color: #b36200;
    }

    .status-badge.delivered, .status-badge.confirmed, .status-badge.processing, .status-badge.packed, .status-badge.shipped {
        background-color: #e3fbeb;
        color: #008060;
    }
    .status-badge.delivered::before, .status-badge.confirmed::before, .status-badge.processing::before, .status-badge.packed::before, .status-badge.shipped::before {
        background-color: #008060;
    }

    .status-badge.cancelled, .status-badge.returned, .status-badge.refunded {
        background-color: #fbeae5;
        color: #ba3c1c;
    }
    .status-badge.cancelled::before, .status-badge.returned::before, .status-badge.refunded::before {
        background-color: #ba3c1c;
    }

    .stock-alert-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px dashed var(--color-admin-border);
    }

    .stock-alert-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .stock-qty-badge {
        background-color: #fbeae5;
        color: #ba3c1c;
        font-family: var(--font-mono);
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.78rem;
    }

    .activity-log-item {
        display: flex;
        gap: 16px;
        padding: 14px 0;
        border-bottom: 1px dashed var(--color-admin-border);
        font-size: 0.86rem;
    }

    .activity-log-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-time {
        font-size: 0.75rem;
        color: var(--color-admin-text-muted);
        flex-shrink: 0;
        width: 75px;
        font-weight: 600;
    }

    @media (max-width: 991px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .charts-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-details-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .kpi-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Metric Cards -->
<section class="kpi-grid">
    <!-- Revenue -->
    <div class="kpi-card">
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
    <div class="kpi-card">
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
    <div class="kpi-card">
        <div class="kpi-card-top">
            <span class="kpi-label">Avg Order Value</span>
            <div class="kpi-icon aov">📈</div>
        </div>
        <span class="kpi-val">₹{{ number_format($averageOrderValue, 2) }}</span>
        <div class="kpi-trend up" style="color: var(--color-admin-gold);">
            <span>▲ 6.1%</span>
            <span style="color: var(--color-admin-text-muted); font-weight: normal;">vs last month</span>
        </div>
    </div>
    
    <!-- Customers -->
    <div class="kpi-card">
        <div class="kpi-card-top">
            <span class="kpi-label">Registered Customers</span>
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
            <select id="chartPeriodSelect" class="admin-select" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 6px; width: auto; font-weight: 700;">
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
        <h2 class="admin-card-title">🌾 Sourcing Category Performance</h2>
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
            <span>🛒 Recent Order Registry</span>
            <a href="{{ route('admin.orders') }}" style="font-size: 0.85rem; color: var(--color-admin-gold); text-decoration: none; font-weight: 700;">View All →</a>
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
                            <td><strong style="font-family: var(--font-mono); font-size: 0.85rem; color: var(--color-admin-accent)">{{ $order->order_number }}</strong></td>
                            <td style="font-weight: 600;">{{ $order->shipping_name }}</td>
                            <td style="font-weight: 700;">₹{{ number_format($order->grand_total, 2) }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td style="color: var(--color-admin-text-muted); font-size: 0.85rem;">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--color-admin-text-muted); padding: var(--spacing-xl);">No orders registered yet.</td>
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
                <span class="status-badge cancelled" style="font-size: 0.7rem;">&lt;= 10 units</span>
            </h2>
            <div>
                @forelse($lowStockVariants as $variant)
                    <div class="stock-alert-item">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-weight: 700; font-size: 0.9rem;">{{ $variant->product->title }}</span>
                            <span style="font-size: 0.78rem; color: var(--color-admin-text-muted); margin-top: 2px;">SKU: <code style="font-family: var(--font-mono); font-weight: bold;">{{ $variant->sku }}</code> &bull; Weight: {{ $variant->weight }}</span>
                        </div>
                        <span class="stock-qty-badge">{{ $variant->stock }} left</span>
                    </div>
                @empty
                    <div style="text-align: center; padding: 24px 0; color: var(--color-admin-accent); font-weight: 700;">
                        🎉 All product variants are fully stocked!
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent activities -->
        <div class="admin-card" style="margin-bottom: 0;">
            <h2 class="admin-card-title">🪵 Recent Inventory Activity</h2>
            <div>
                @forelse($recentActivities as $log)
                    <div class="activity-log-item">
                        <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                        <div>
                            <span style="font-weight: 700; color: var(--color-admin-text-main)">{{ $log->type }}</span>: 
                            <strong style="color: {{ $log->quantity_change > 0 ? 'var(--color-admin-accent)' : '#ba3c1c' }}">{{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }}</strong> units for 
                            {{ $log->variant->product->title ?? 'Deleted Product' }} ({{ $log->variant->weight ?? 'N/A' }})
                            <span style="display: block; font-size: 0.78rem; color: var(--color-admin-text-muted); margin-top: 3px; font-style: italic;">"{{ $log->log_message }}"</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 24px 0; color: var(--color-admin-text-muted);">
                        No inventory adjustments logged yet.
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
