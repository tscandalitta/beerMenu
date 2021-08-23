<?php

namespace App\Http\Controllers;

use App\Models\AtentionRequest;
use App\Models\Order;
use App\Models\Table;

class AtentionRequestController extends Controller
{
    public function index()
    {
        return response()->json(AtentionRequest::all());
    }

    public function store()
    {
        $table = Table::find(request("table"));
        if($table->token == request("token")) {
            $atentionRequest = AtentionRequest::create([
                'table_id' => $table->id,
                'type' => request('type'),
                'comments' => request('comments'),
            ]);
            $atentionRequest->save();
            return response()->json($atentionRequest);
        }
        return response()->json(["msg" => "Unauthorized"], 401);

    }
}
