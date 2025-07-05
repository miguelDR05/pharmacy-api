<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'receipt_number' => $this->receipt_number,
            'total' => $this->total,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'user' => new UserResource($this->whenLoaded('user')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'items' => SaleItemResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
