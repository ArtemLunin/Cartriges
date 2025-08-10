<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartridgeModel extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'capacity', 'cost'];

    protected $attributes = ['capacity' => 700, 'cost' => 0];

    public $timestamps = false;

    public function cartridges()
    {
        return $this->hasMany(Cartridge::class);
    }
}
