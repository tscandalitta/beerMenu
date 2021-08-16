<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function items(){
        return $this->belongsToMany(Item::class);
    }

    public function table(){
        return $this->hasOne(Table::class);
    }
}
