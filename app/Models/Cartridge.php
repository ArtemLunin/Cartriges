<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartridge extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'barcode', 'comment', 'working', 'place_id'];

    protected $attributes = [
        'working' => 1,
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
