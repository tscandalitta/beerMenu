<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function items(){
        return $this->belongsToMany(Item::class)
            ->withPivot("items_amount");
    }

    public function table(){
        return $this->hasOne(Table::class);
    }

    public function getTotal(){
        return $this->items->reduce(function ($carry, $item) {
            return $carry + $item->price * $item->pivot->items_amount;
        });
    }
}
