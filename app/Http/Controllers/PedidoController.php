<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = auth()->user()->pedidos()
            ->latest()
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(StorePedidoRequest $request)
    {
    $data = $request->validated();

    auth()->user()->pedidos()->create($data);

    return redirect()
        ->route('pedidos.index')
        ->with('success', 'Pedido registrado correctamente.');
    }

    public function show(string $id)
    {
        $pedido = auth()->user()->pedidos()->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }

    public function edit(string $id)
    {
        $pedido = auth()->user()->pedidos()->findOrFail($id);

        return view('pedidos.edit', compact('pedido'));
    }

    public function update(UpdatePedidoRequest $request, string $id)
    {
        $pedido = auth()->user()->pedidos()->findOrFail($id);

        $pedido->update($request->validated());

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $pedido = auth()->user()->pedidos()->findOrFail($id);

        $pedido->delete();

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}
