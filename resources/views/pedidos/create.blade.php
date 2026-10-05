@extends('layouts.app')

@section('title', 'Nuevo Pedido')

@section('content')

    <div class="card">

        <h1>Registrar Nuevo Pedido</h1>

        <p>Completa los datos del pedido.</p>

        @if ($errors->any())
            <div class="alert">
                <strong>Por favor corrige los siguientes errores:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pedidos.store') }}" method="POST">

            @csrf

            <div>
                <label for="cliente">Cliente:</label>
                <input
                    type="text"
                    id="cliente"
                    name="cliente"
                    value="{{ old('cliente') }}"
                >
            </div>

            <br>

            <div>
                <label for="telefono">Teléfono:</label>
                <input
                    type="text"
                    id="telefono"
                    name="telefono"
                    value="{{ old('telefono') }}"
                >
            </div>

            <br>

            <div>
                <label for="direccion">Dirección:</label>
                <textarea
                    id="direccion"
                    name="direccion"
                    rows="3"
                >{{ old('direccion') }}</textarea>
            </div>

            <br>

            <div>
                <label for="producto">Producto:</label>
                <input
                    type="text"
                    id="producto"
                    name="producto"
                    value="{{ old('producto') }}"
                >
            </div>

            <br>

            <div>
                <label for="cantidad">Cantidad:</label>
                <input
                    type="number"
                    id="cantidad"
                    name="cantidad"
                    min="1"
                    value="{{ old('cantidad', 1) }}"
                >
            </div>

            <br>

            <div>
                <label for="total">Total:</label>
                <input
                    type="number"
                    id="total"
                    name="total"
                    min="0"
                    step="0.01"
                    value="{{ old('total') }}"
                >
            </div>

            <br>

            <div>
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">

                    <option value="Pendiente"
                        {{ old('estado', 'Pendiente') === 'Pendiente' ? 'selected' : '' }}>
                        Pendiente
                    </option>

                    <option value="Preparando"
                        {{ old('estado') === 'Preparando' ? 'selected' : '' }}>
                        Preparando
                    </option>

                    <option value="En camino"
                        {{ old('estado') === 'En camino' ? 'selected' : '' }}>
                        En camino
                    </option>

                    <option value="Entregado"
                        {{ old('estado') === 'Entregado' ? 'selected' : '' }}>
                        Entregado
                    </option>

                    <option value="Cancelado"
                        {{ old('estado') === 'Cancelado' ? 'selected' : '' }}>
                        Cancelado
                    </option>

                </select>
            </div>

            <br>

            <div>
                <label for="costo_express">Costo Express:</label>
                <input
                    type="number"
                    id="costo_express"
                    name="costo_express"
                    min="0"
                    step="0.01"
                    value="{{ old('costo_express', '5.00') }}"
                >
            </div>

            <br>

            <div>
                <label for="fecha_pedido">Fecha del pedido:</label>
                <input
                    type="date"
                    id="fecha_pedido"
                    name="fecha_pedido"
                    value="{{ old('fecha_pedido', date('Y-m-d')) }}"
                >
            </div>

            <br>

            <button type="submit" class="btn btn-success">
                Registrar Pedido
            </button>

            <a href="{{ route('pedidos.index') }}" class="btn">
                Cancelar
            </a>

        </form>

    </div>

@endsection