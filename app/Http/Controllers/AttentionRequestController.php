<?php

namespace App\Http\Controllers;

use App\Models\AttentionRequest;
use App\Models\Order;
use App\Models\Table;

class AttentionRequestController extends Controller
{
    public function index()
    {
        return response()->json(AttentionRequest::all());
    }

    public function store()
    {
        $table = Table::find(request("table"));
        if($table->token == request("token")) {
            $attentionRequest = AttentionRequest::create([
                'table_id' => $table->id,
                'type' => request('type'),
                'comments' => request('comments'),
            ]);
            $attentionRequest->save();
            return response()->json($attentionRequest);
        }
        return response()->json(["msg" => "Unauthorized"], 401);

    }

    public function destroy(AttentionRequest $attentionRequest)
    {
        $table = Table::find(request("table"));
        if($table->token == request("token")) {
            AttentionRequest::destroy($attentionRequest->id);
            return response()->json();
        }
        return response()->json(["msg" => "Unauthorized"], 401);
    }
}
