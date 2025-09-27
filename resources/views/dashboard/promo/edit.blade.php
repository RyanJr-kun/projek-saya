<x-layout>
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Page', 'url' => '#'],
                ['name' => 'Manajemen Promo & Diskon', 'url' => route('promo.index')],
                ['name' => 'Edit Promo', 'url' => '#'],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <h6 class="mb-0">Edit Promo: {{ $promo->nama_promo }}</h6>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('promo.update', $promo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger text-white mt-3" role="alert">
                            <strong class="font-weight-bold">Oops! Terjadi kesalahan:</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('dashboard.promo._form', ['promo' => $promo])

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('promo.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
