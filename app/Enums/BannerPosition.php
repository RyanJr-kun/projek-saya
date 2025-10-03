<?php

namespace App\Enums;

// 1. Tambahkan ": string" untuk menjadikannya "Backed Enum"
enum BannerPosition: string
{
    case MAIN_CAROUSEL  = 'main_carousel';
    case PROMO_VERTIKAL = 'promo_vertikal';
    case BESTSELLER     = 'bestseller';

    // 💡 Pro Tip: Anda bisa menambahkan helper function di sini jika perlu,
    // misalnya untuk mendapatkan daftar nama yang lebih ramah untuk dropdown.
    public function getLabel(): string
    {
        return match ($this) {
            self::MAIN_CAROUSEL => 'Main Carousel',
            self::PROMO_VERTIKAL => 'Promo Vertikal',
            self::BESTSELLER => 'Bestseller',
        };
    }
}
