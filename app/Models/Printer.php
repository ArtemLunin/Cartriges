<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'comment', 'place_id'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
