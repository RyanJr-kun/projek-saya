<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Dashboard', 'url' => route('dashboard')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card rounded-2">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Pendapatan Hari Ini</p>
                                    <h5 class="font-weight-bolder">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h5>
                                    <p class="mb-0">
                                        <span class="text-sm font-weight-bolder {{ $persentasePendapatan >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $persentasePendapatan >= 0 ? '+' : '' }}{{ number_format($persentasePendapatan, 2) }}%
                                        </span>
                                        dari kemarin
                                    </p>
                                </div>
                            </div>
                            <div class="col text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="bi bi-cash-coin text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card rounded-2">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Transaksi Hari Ini</p>
                                    <h5 class="font-weight-bolder">{{ $transaksiHariIni }}</h5>
                                    <p class="mb-0">
                                        <span class="text-sm font-weight-bolder {{ $persentaseTransaksi >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $persentaseTransaksi >= 0 ? '+' : '' }}{{ number_format($persentaseTransaksi, 2) }}%
                                        </span>
                                        dari kemarin
                                    </p>
                                </div>
                            </div>
                            <div class="col text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="bi bi-receipt-cutoff text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card rounded-2">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Stok Rendah</p>
                                    <h5 class="font-weight-bolder">{{ $stokRendahCount }} Produk</h5>
                                    <p class="mb-0">
                                        <a href="{{ route('stok.rendah') }}" class="text-warning text-sm font-weight-bolder">Lihat Detail</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="bi bi-box-seam text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card rounded-2">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Pelanggan Baru</p>
                                    <h5 class="font-weight-bolder">{{ $pelangganBaruCount }}</h5>
                                    <p class="mb-0">
                                        <span class="text-dark text-sm font-weight-bolder">Bulan Ini</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="bi bi-people-fill text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-8 mb-lg-0 mb-4">
                <div class="card z-index-2 rounded-2 ">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Penjualan (30 Hari Terakhir)</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success me-1"></i>
                            <span class="font-weight-bold">Total Pendapatan</span> bulan ini
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="350"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-2">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Produk Terlaris Bulan Ini</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @forelse ($produkTerlaris as $produk)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $produk->img_produk ? asset('storage/' . $produk->img_produk) : asset('assets/img/produk.webp') }}" class="avatar avatar-sm me-3" alt="Gambar produk">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $produk->nama_produk }}</h6>
                                            <span class="text-xs"><span class="font-weight-bold">{{ $produk->total_terjual }}</span> terjual</span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item border-0 ps-0 text-center">
                                    <p class="text-sm text-muted">Belum ada produk yang terjual bulan ini.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: {!! json_encode($salesChartLabels) !!},
        datasets: [{
          label: "Pendapatan",
          tension: 0.4,
          pointRadius: 2,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: {!! json_encode($salesChartData) !!}

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
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
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
                display: true,
                padding: 10,
                color: '#6c757d',
                font: {
                    size: 11,
                    family: "Open Sans",
                    style: 'normal',
                    lineHeight: 2
                },
                callback: function(value, index, values) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                }
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#6c757d',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
@endpush
</x-layout>
