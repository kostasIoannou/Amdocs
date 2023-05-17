<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GeneratesUniqueCode;

class Product extends Model
{
    use HasFactory,GeneratesUniqueCode;

    public $table = 'products';

    protected $dates = [
        'release_date',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'code',
        'category_id',
        'price',
        'release_date',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-y H:i:s');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
