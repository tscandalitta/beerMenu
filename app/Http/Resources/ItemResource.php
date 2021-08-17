<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{

    protected $order_id;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $order_id)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        $this->order_id = $order_id;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = [];
        foreach($this->resource as $item) {

            array_push($items, [
                'name' => $item->name,
                'description' => $item->description,
                'price' => $item->price,
                'in_stock' => $item->in_stock,
                'amount' => $item->orders->find($this->order_id)->pivot->items_amount,
            ]);

        }
        return $items;
    }
}
