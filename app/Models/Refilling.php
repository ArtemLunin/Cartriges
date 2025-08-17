<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refilling extends Model
{
    use HasFactory;

    protected $fillable = ['date_dispatch', 'date_receipt', 'completed', 'cartridge_id'];

    protected $attributes = ['completed' => 0];

    protected $casts = [
        'completed' => 'boolean',
        'date_dispatch' => 'datetime',
        'date_receipt' => 'datetime',
    ];
    
    public $timestamps = false;

    public function cartridge()
    {
        return $this->belongsTo(Cartridge::class);
    }
}
