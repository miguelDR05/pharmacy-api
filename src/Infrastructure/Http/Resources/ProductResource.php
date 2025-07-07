<?php

namespace Infrastructure\Http\Resources;

use Domain\Entities\Product as ProductEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'price' => $this->price,
            'cost' => $this->cost,
            'stock' => $this->stock,
            'min_stock' => $this->min_stock,
            'is_active' => $this->is_active,
            'requires_prescription' => $this->requires_prescription,
            'is_low_stock' => $this->isLowStock(),
            // 'category' => new CategoryResource($this->whenLoaded('category')),
            'category' => $this->category_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
