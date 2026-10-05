@extends('layouts.app')

@section('title', 'Detalle del Pedido')

@section('content')

    <div class="card">

        <h1>Detalle del Pedido #{{ $pedido->id }}</h1>

        <p>
            <strong>Cliente:</strong>
            {{ $pedido->cliente }}
        </p>

        <p>
            <strong>Teléfono:</strong>
            {{ $pedido->telefono }}
        </p>

        <p>
            <strong>Dirección:</strong>
            {{ $pedido->direccion }}
        </p>

        <p>
            <strong>Producto:</strong>
            {{ $pedido->producto }}
        </p>

        <p>
            <strong>Cantidad:</strong>
            {{ $pedido->cantidad }}
        </p>

        <p>
            <strong>Total:</strong>
            ${{ number_format($pedido->total, 2) }}
        </p>

        <p>
            <strong>Estado:</strong>
            {{ $pedido->estado }}
        </p>

        <p>
            <strong>Costo Express:</strong>
            ${{ number_format($pedido->costo_express, 2) }}
        </p>

        <p>
            <strong>Fecha del pedido:</strong>
            {{ $pedido->fecha_pedido->format('d/m/Y') }}
        </p>

        <hr>

        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-primary">
            Editar
        </a>

        <a href="{{ route('pedidos.index') }}" class="btn">
            Volver a pedidos
        </a>

    </div>

@endsection