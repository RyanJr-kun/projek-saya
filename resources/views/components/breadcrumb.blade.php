@props(['items' => []])

@if (!empty($items))
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 py-1 px-0 me-sm-6 me-5 d-none d-md-flex">
        @foreach ($items as $item)
            {{-- Jika item tersebut bukan item terakhir, maka buat sebagai link --}}
            @if (!$loop->last)
                <li class="breadcrumb-item text-sm text-white">
                    <a href="{{ $item['url'] }}" class="text-white">{{ $item['name'] }}</a>
                </li>
            @else
                {{-- Jika ini item terakhir, buat sebagai teks aktif tanpa link --}}
                <li class="breadcrumb-item text-white active" aria-current="page">
                    {{ $item['name'] }}
                </li>
            @endif
        @endforeach
    </ol>
    <h4 class="font-weight-bolder text-white mt-3 mt-md-0">{{ last($items)['name'] ?? '' }}</h4>
</nav>
@endif
