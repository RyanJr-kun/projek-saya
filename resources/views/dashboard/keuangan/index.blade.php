<x-layout>
    @push('styles')
        {{-- Tambahkan style khusus jika diperlukan --}}
    @endpush
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Administrasi Keuangan', 'url' => route('keuangan')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid py-4">
      {{-- Bagian Ringkasan Keuangan --}}
      <div class="row mb-4">
        <div class="col-lg-8 mb-lg-0 mb-4">
          <div class="row">
            <div class="col-xl-6 mb-xl-0 mb-4">
              <div class="card bg-transparent shadow-xl">
                <div class="overflow-hidden position-relative border-radius-xl" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/card-visa.jpg');">
                  <span class="mask bg-gradient-dark"></span>
                  <div class="card-body position-relative z-index-1 p-3">
                    <i class="fas fa-wifi text-white p-2"></i>
                    <h5 class="text-white mt-4 mb-5 pb-2">Laba / Rugi <br> ({{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM') }} - {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }})</h5>
                    <div class="d-flex">
                      <div class="d-flex">
                        <div class="me-4">
                          <p class="text-white text-sm opacity-8 mb-0">Status</p>
                          <h6 class="text-white mb-0 {{ $labaRugi >= 0 ? 'text-success' : 'text-danger' }}">{{ $labaRugi >= 0 ? 'Laba' : 'Rugi' }}</h6>
                        </div>
                        <div>
                          <p class="text-white text-sm opacity-8 mb-0">Jumlah</p>
                          <h6 class="text-white mb-0">@money($labaRugi)</h6>
                        </div>
                      </div>
                      <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                        <i class="bi bi-graph-up-arrow text-white text-gradient fa-3x"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 mt-xl-0 mt-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
                        <i class="bi bi-arrow-down-circle-fill opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Total Pemasukan</h6>
                      <span class="text-xs">Jumlah pendapatan</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0 text-success">@money($totalPemasukan)</h5>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-danger shadow text-center border-radius-lg">
                        <i class="bi bi-arrow-up-circle-fill opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Total Pengeluaran</h6>
                      <span class="text-xs">Jumlah biaya operasional</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0 text-danger">@money($totalPengeluaran)</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- Invoice Terbaru --}}
        <div class="col-lg-4">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <div class="row">
                <div class="col-6 d-flex align-items-center">
                  <h6 class="mb-0">Invoice Terbaru</h6>
                </div>
                <div class="col-6 text-end">
                  <a href="{{ route('penjualan.index') }}" class="btn btn-outline-primary btn-sm mb-0">Lihat Semua</a>
                </div>
              </div>
            </div>
            <div class="card-body p-3 pb-0">
                <ul class="list-group">
                    @forelse ($recentInvoices as $invoice)
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">{{ $invoice->tanggal_penjualan }}</h6>
                            <span class="text-xs">{{ $invoice->referensi }}</span>
                        </div>
                        <div class="d-flex align-items-center text-sm">
                            @money($invoice->total_akhir)
                            <a href="{{ route('penjualan.show', $invoice->referensi) }}" class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i class="fas fa-file-pdf text-lg me-1"></i> PDF</a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item border-0 text-center">
                        <p class="text-muted text-sm">Belum ada invoice penjualan.</p>
                    </li>
                    @endforelse
                </ul>
            </div>
          </div>
        </div>
      </div>
      {{-- Bagian Grafik Keuangan --}}
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Grafik Keuangan</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-arrow-up text-success"></i>
                        <span class="font-weight-bold">Pemasukan</span> vs
                        <i class="fa fa-arrow-down text-danger"></i>
                        <span class="font-weight-bold">Pengeluaran</span>
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="financial-chart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
      </div>

      {{-- Bagian Transaksi Terbaru --}}
      <div class="row">
        <div class="col-md-12 mt-4">
          <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Transaksi Terakhir</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                  <i class="far fa-calendar-alt me-2"></i>
                  <small>{{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM') }} - {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }}</small>
                </div>
              </div>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    @forelse ($recentTransactions as $transaction)
                        @php
                            $isPemasukan = $transaction->type === 'pemasukan';
                            $iconClass = $isPemasukan ? 'fa-arrow-down text-success' : 'fa-arrow-up text-danger';
                            $amountClass = $isPemasukan ? 'text-success' : 'text-danger';
                            $amountSign = $isPemasukan ? '+' : '-';
                        @endphp
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-icon-only btn-rounded btn-outline-{{ $isPemasukan ? 'success' : 'danger' }} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                    <i class="fas {{ $iconClass }}"></i>
                                </button>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">{{ $transaction->deskripsi }}</h6>
                                    <span class="text-xs">{{ \Carbon\Carbon::parse($transaction->tanggal)->isoFormat('D MMM Y, HH:mm') }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center {{ $amountClass }} text-gradient text-sm font-weight-bold">
                                {{ $amountSign }} @money($transaction->jumlah)
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item border-0 text-center">
                            <p class="text-muted text-sm">Belum ada transaksi pada periode ini.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('financial-chart').getContext('2d');
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Pemasukan',
                        data: chartData.pemasukan,
                        borderColor: 'rgba(20, 214, 125, 1)',
                        backgroundColor: 'rgba(20, 214, 125, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgba(20, 214, 125, 1)',
                    }, {
                        label: 'Pengeluaran',
                        data: chartData.pengeluaran,
                        borderColor: 'rgba(234, 51, 94, 1)',
                        backgroundColor: 'rgba(234, 51, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgba(234, 51, 94, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    plugins: {
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
