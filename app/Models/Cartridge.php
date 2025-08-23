<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartridge extends Model
{
    use HasFactory;

    protected $fillable = ['model_id', 'barcode', 'comment', 'working', 'place_id'];

    protected $attributes = ['working' => 1];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(CartridgeModel::class, 'model_id', 'id');
    }

    public function refillings()
    {
        return $this->hasMany(Refilling::class);
    }
}
