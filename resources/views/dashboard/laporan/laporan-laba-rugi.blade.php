<x-layout>
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Laporan', 'url' => '#'],
                ['name' => 'Laba Rugi', 'url' => route('laporan.laba-rugi')]
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">Laporan Laba Rugi</h6>
                        <p class="text-sm mb-0">Menampilkan ringkasan pendapatan, beban, dan laba bersih.</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                {{-- Filter Section --}}
                <div class="filter-container p-3 border-bottom mb-4">
                    <form action="{{ route('laporan.laba-rugi') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                            </div>
                            <div class="col-md-3 d-flex">
                                <button type="submit" class="btn btn-dark w-50 me-2">Filter</button>
                                <a href="{{ route('laporan.laba-rugi') }}" class="btn btn-outline-secondary w-50">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Report Summary --}}
                <div class="report-summary px-3">
                    <h5 class="mb-3">Ringkasan untuk Periode: <span class="fw-bold">{{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }}</span></h5>

                    <ul class="list-group">
                        {{-- Pendapatan --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Pendapatan dari Penjualan</span>
                            <span class="fw-bold text-success">@money($totalRevenue)</span>
                        </li>

                        {{-- HPP --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Harga Pokok Penjualan (HPP)</span>
                            <span>(@money($cogs))</span>
                        </li>

                        {{-- Laba Kotor --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center border-top pt-3">
                            <span class="fw-bold">Laba Kotor</span>
                            <span class="fw-bold">@money($grossProfit)</span>
                        </li>

                        {{-- Beban --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center mt-3">
                            <span class="fw-bold">Beban Operasional</span>
                            <span>(@money($totalExpenses))</span>
                        </li>

                        {{-- Laba Bersih --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center border-top pt-3 {{ $netProfit >= 0 ? 'bg-success-light' : 'bg-danger-light' }}">
                            <h5 class="mb-0">Laba Bersih</h5>
                            <h5 class="mb-0 {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">@money($netProfit)</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Chart Section --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card z-index-2">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Laba Rugi 6 Bulan Terakhir</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold">Laba</span> vs
                            <i class="fa fa-arrow-down text-danger"></i>
                            <span class="font-weight-bold">Rugi</span>
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="profit-loss-chart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('profit-loss-chart').getContext('2d');
            const labels = @json($chartLabels);
            const data = @json($chartNetProfits);

            // Atur warna bar berdasarkan nilai laba (positif) atau rugi (negatif)
            const backgroundColors = data.map(value => value >= 0 ? 'rgba(20, 214, 125, 0.8)' : 'rgba(234, 51, 94, 0.8)');
            const borderColors = data.map(value => value >= 0 ? 'rgba(20, 214, 125, 1)' : 'rgba(234, 51, 94, 1)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Laba Bersih',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legenda karena warna sudah jelas
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-layout>
