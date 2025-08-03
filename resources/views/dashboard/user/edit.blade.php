<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    @push('breadcrumb')
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $bread }}</li>
    @endpush
    <div class="card m-4 p-3">
        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <p class="text-dark ms-2 my-0"></p>
            <a href="javascript:;" class="d-block">
            <img src="" class="w-10 h-10 border-radius-lg">
            </a>
        </div>
        <div class="card-body pt-2">
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2"> Form buat edit</span>
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">sama create</span>
            <a href="javascript:;" class="card-title h5 d-block text-darker">
            ryan junior
            </a>
            <h3 class=" mb-4"> Rp.regane</h3>
            <div class="author align-items-center">
                <img src="ndak ada" alt="..." class="avatar shadow">
                <div class="name ps-3">
                    <span></span>
                    <div class="stats">
                        <p class="text-dark">sisa produk <small class=" fw-bold text-dark"></small></p>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{  }}" class="btn btn-sm btn-outline-primary">Back</a>
    </div>
</x-layout>


