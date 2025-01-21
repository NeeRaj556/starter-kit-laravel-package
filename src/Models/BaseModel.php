<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeVeritified($query)
    {
        return $query->where('verified', 1);
    }

    
}
