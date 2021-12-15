<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Libraries\StartDateBuilder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        if(request("in_stock") == "true"){
            return response()->json(Item::where("in_stock", true)->get());
        }
        return response()->json(Item::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $item = Item::create($request->all());
        return response()->json($item);
    }

    /**
     * Display the specified resource.
     *
     * @param Item $item
     * @return JsonResponse
     */
    public function show(Item $item)
    {
        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Item $item
     * @return Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Item $item
     * @return JsonResponse
     */
    public function update(Request $request, Item $item)
    {
        $item->fill($request->all());
        $item->save();
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return Response
     */
    public function destroy(Item $item)
    {

    }

    public function summary()
    {
        $startDate = StartDateBuilder::getStartDate();

        $orders = Order::where('created_at', '>=', $startDate)->get();
        $items = [];

        foreach ($orders as $order) {
            foreach ($order->items as $order_item) {
                $item = Item::find($order_item->pivot->item_id);
                if (array_key_exists($item->name, $items))
                    $items[$item->name] += intval($order_item->pivot->items_amount);
                else
                    $items[$item->name] = intval($order_item->pivot->items_amount);
            }
        }
        return response()->json($items);
    }

}
