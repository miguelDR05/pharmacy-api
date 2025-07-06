php
<?php

namespace Infrastructure\Http\Requests; // Namespace actualizado

use Illuminate\Foundation\Http\FormRequest; // Asegúrate de que esta importación es correcta si cambiaste la ubicación
use Illuminate\Validation\Rule; // Importar Rule para la validación unique

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Generalmente true si la lógica de autorización se maneja en otro lugar (policies, middleware)
        return true;
    }

    public function rules(): array
    {
        // Obtenemos el ID del producto de la ruta si estamos en una operación de actualización
        $productId = $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'barcode' => ['nullable', 'string', Rule::unique('products', 'barcode')->ignore($productId)], // Validación unique para barcode, ignorando el producto actual en caso de actualización
            'price' => ['required', 'numeric', 'min:0'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'], // Actualizado de cost
            'stock' => ['required', 'integer', 'min:0'],
            'expiration_date' => ['nullable', 'date'], // Agregado: fecha de vencimiento
            'active' => ['boolean'], // Actualizado de is_active
            'min_stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'expiration_date' => ['nullable', 'date'], // Agregado: fecha de vencimiento
            'active' => ['boolean'], // Actualizado de is_active
            // Si necesitas validar 'requires_prescription', agrégalo aquí
            // 'requires_prescription' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'barcode.unique' => 'El código de barras ya existe.',
            'price.required' => 'El precio de venta es obligatorio.',
            'price.numeric' => 'El precio de venta debe ser un número.',
            'price.min' => 'El precio de venta debe ser mayor o igual a 0.',
             'purchase_price.numeric' => 'El precio de compra debe ser un número.',
            'purchase_price.min' => 'El precio de compra debe ser mayor o igual a 0.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
             'min_stock.required' => 'El stock mínimo es obligatorio.',
            'min_stock.integer' => 'El stock mínimo debe ser un número entero.',
            'min_stock.min' => 'El stock mínimo no puede ser negativo.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'expiration_date.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            'active.boolean' => 'El estado activo debe ser verdadero o falso.',
            // Agrega mensajes para otros campos si lo deseas
        ];
    }
}
