<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Libraries\StartDateBuilder;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if(in_array(request("state"), ["OPEN", "CLOSED"])){

            return response()->json(OrderResource::collection(Order::where("state", request("state"))->get()));
        }
        return response()->json(OrderResource::collection(Order::all()));
    }

    public function ordersByTable(Table $table)
    {
        if(request("token") == $table->token){
            $ordersFiltered = Order::where("token", request("token"))->get();
            return response()->json(OrderResource::collection($ordersFiltered));
        }
        return response()->json(["msg" => "Unauthorized Request"], 401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
        $table = Table::find($request->input("table"));
        if($table->token == $request->input("token")){
            $order = Order::create();
            $this->associateItemsToOrder($request, $order);
            $order->table_id = $request->input("table");
            $order->token = $request->input("token");
            $order->comments = $request->input("comments");
            $order->save();
            return response()->json($order);
        }
        return response()->json(["msg" => "Unauthorized"], 401);

    }

    public function associateItemsToOrder($request, $order){
        foreach ($request->input("items") as $key => $item){
            $order->items()->attach($item, ["items_amount" => $request->input("quantities")[$key]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Order $order)
    {
        $order->fill($request->all());
        $order->save();
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function totalEarns()
    {
        $startDate = StartDateBuilder::getStartDate();
        $closedOrders = Order::where("updated_at", ">=", $startDate)
                            ->where("state", "=", "CLOSED")
                            ->get();

        $total = $closedOrders->reduce(function ($carry, $order) {
            return $carry + $order->getTotal();
        }, 0);

        return response()->json(["total" => $total]);
    }

    public function realTime() {
        return view('orders.realtime');
    }
}
