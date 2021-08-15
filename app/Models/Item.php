<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function orders(){
        return $this->belongsToMany(Order::class)
            ->withPivot("items_amount");
    }
}
