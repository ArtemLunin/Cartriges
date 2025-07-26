<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['place_name', 'comment'];

    public function printers()
    {
        return $this->hasMany(Printer::class);
    }

    public function cartridges()
    {
        return $this->hasMany(Cartridge::class);
    }
}
