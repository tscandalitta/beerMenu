<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    const DEFAULT_DELTA_DAYS = 0;
    const DEFAULT_DELTA_HOURS = 0;
    const HISTORICAL_FLAG = -1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $item = Item::create($request->all());
        return response()->json($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Item $item)
    {
        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
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
     * @param  \App\Models\Item  $item
     * @return Response
     */
    public function destroy(Item $item)
    {

    }

    public function summary()
    {
        $delta_days = request('days', self::DEFAULT_DELTA_DAYS);
        $delta_hours = request('hours', self::DEFAULT_DELTA_HOURS);

        if ($delta_days != self::HISTORICAL_FLAG) {
            $delta_seconds = $delta_days * 24 * 60 * 60 + $delta_hours * 60 * 60;
            $start_date_seconds = (new DateTime())->getTimestamp() - $delta_seconds;
            $start_date = $this->createDate($start_date_seconds);
        }
        else
            $start_date = $this->createDate(0);

        $orders = Order::where('created_at','>=',$start_date)->get();
        $items = [];

        foreach ($orders as $order) {
            foreach ($order->items as $order_item) {
                $item_id = $order_item->pivot->item_id;
                if (array_key_exists($item_id, $items))
                    $items[$item_id] += intval($order_item->pivot->items_amount);
                else
                    $items[$item_id] = intval($order_item->pivot->items_amount);
            }
        }
        return response()->json($items);
    }

    function createDate($timestamp)
    {
        return (new DateTime())->setTimestamp($timestamp)->format("Y-m-d H:i:s");
    }
}
