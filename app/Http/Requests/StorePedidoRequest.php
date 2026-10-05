<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'cliente' => ['required', 'string', 'max:100'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string'],
            'producto' => ['required', 'string', 'max:150'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'total' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', 'in:Pendiente,Preparando,En camino,Entregado,Cancelado'],
            'costo_express' => ['required', 'numeric', 'min:0'],
            'fecha_pedido' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'cliente.required' => 'El nombre del cliente es obligatorio.',
            'cliente.max' => 'El nombre del cliente no puede superar los 100 caracteres.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',

            'direccion.required' => 'La dirección es obligatoria.',

            'producto.required' => 'El producto es obligatorio.',
            'producto.max' => 'El producto no puede superar los 150 caracteres.',

            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser como mínimo 1.',

            'total.required' => 'El total es obligatorio.',
            'total.numeric' => 'El total debe ser un valor numérico.',
            'total.min' => 'El total no puede ser negativo.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',

            'costo_express.required' => 'El costo express es obligatorio.',
            'costo_express.numeric' => 'El costo express debe ser un valor numérico.',
            'costo_express.min' => 'El costo express no puede ser negativo.',

            'fecha_pedido.required' => 'La fecha del pedido es obligatoria.',
            'fecha_pedido.date' => 'La fecha del pedido no es válida.',
        ];
    }
}
