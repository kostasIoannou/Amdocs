<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\Product;

trait GeneratesUniqueCode
{
    public static function generateUniqueCode(): string
    {
        // Check if the generated code already exists in the database
        do {
            $randomLetters = Str::lower(Str::random(5));
            $code = 'amdocs-' . $randomLetters;
        } while (Product::where('code', $code)->exists());

        return $code;
    }
}