@props(['status'])

@php
    $badgeClass = '';
    switch ($status) {
        case 'Lunas':
            $badgeClass = 'badge-success';
            break;
        case 'Belum Lunas':
            $badgeClass = 'badge-warning';
            break;
        case 'Dibatalkan':
            $badgeClass = 'badge-danger';
            break;
        case 'Lunas Sebagian':
            $badgeClass = 'badge-info';
            break;
        default:
            $badgeClass = 'badge-secondary';
            break;
    }
@endphp

<span class="badge badge-sm {{ $badgeClass }}">{{ $status }}</span>
