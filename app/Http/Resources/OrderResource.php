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
        $items = new ItemResource($this->items, $this->id);
        return [
            'comments' => $this->comments,
            'state' => $this->state,
            'table' => $this->table_id,
            'items' => $items,
            'total' => $items->sum('price'),
            'created_at' => $this->created_at
        ];
    }
}
