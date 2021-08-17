<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = ItemWithPivotResource::collection($this->items);
        return [
            'comments' => $this->comments,
            'state' => $this->state,
            'table' => $this->table_id,
            'items' => $items,
            'total' => $this->getTotal(),
            'created_at' => $this->created_at
        ];
    }
}
