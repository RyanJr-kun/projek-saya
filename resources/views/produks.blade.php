@extends('layouts.main')

@section('container')


<div class="card m-4 p-3">

  <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
    <p class="text-dark ms-2 my-0">{{ $produk->sku }}</p>
    <a href="javascript:;" class="d-block">
      <img src="{{ $produk->img_produk }}" class="w-10 h-10 border-radius-lg">
    </a>
    <p></p>
  </div>

  <div class="card-body pt-2">
    <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">{{ $produk->brand }}</span>
    <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">{{ $produk->kategori_produk->nama }}</span>
    <a href="javascript:;" class="card-title h5 d-block text-darker">
      {{ $produk->nama }}
    </a>
    <h3 class=" mb-4"> Rp.{{ $produk->harga }}</h3>
    <div class="author align-items-center">
      <img src="{{ $produk->user->img_user }}" alt="..." class="avatar shadow">
      <div class="name ps-3">
        <span>{{ $produk->pembuat }}</span>
        <div class="stats">
            <p class="text-dark">sisa produk <small class=" fw-bold text-dark">{{ $produk->qty }}</small></p>
        </div>
      </div>
    </div>
  </div>
    <a href="/produk" class="btn btn-sm btn-outline-primary w-20 ">Back</a>
</div>

@endsection
@section('corejs')

@endsection
