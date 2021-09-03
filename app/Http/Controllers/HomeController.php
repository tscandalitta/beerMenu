<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listItems(){
        return view('items.list_items');
    }

    public function createItem(){
        return view('items.create_item');
    }

    public function updateItem(Item $item){
        return view('items.edit_item');
    }
}
