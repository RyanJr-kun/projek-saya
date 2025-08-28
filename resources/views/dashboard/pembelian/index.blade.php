<x-layout>
    {{-- breadcrumb --}}
        @section('breadcrumb')
            @php
            // Definisikan item breadcrumb dalam bentuk array
            $breadcrumbItems = [
                ['name' => 'Page', 'url' => '/dashboard'],
                ['name' => 'Manajemen Produk', 'url' => route('produk.index')],
                ['name' => 'Buat Produk Baru', 'url' => '#'],
            ];
            @endphp
            <x-breadcrumb :items="$breadcrumbItems" />
        @endsection
    {{-- notif-success-create-user --}}
        @if (session()->has('success'))
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <span class="alert-icon text-light me-2"><i class="fa fa-thumbs-up"></i></span>
                    <strong class="me-auto">Notifikasi</strong>
                    <small class="text-light">Baru saja</small>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
        @endif



    @push('scripts')
    @endpush
</x-layout>
