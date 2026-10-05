@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')

    <div class="card">

        <h1>Mis Pedidos</h1>

        <p>Listado de pedidos del usuario autenticado.</p>

        @if (session('success'))
            <div class="alert" style="background-color: #dcfce7; color: #166534;">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">
            Nuevo pedido
        </a>

        @if ($pedidos->count() > 0)

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($pedidos as $pedido)

                        <tr>

                            <td>{{ $pedido->id }}</td>

                            <td>{{ $pedido->cliente }}</td>

                            <td>{{ $pedido->producto }}</td>

                            <td>{{ $pedido->cantidad }}</td>

                            <td>
                                ${{ number_format($pedido->total, 2) }}
                            </td>

                            <td>{{ $pedido->estado }}</td>

                            <td>
                                {{ $pedido->fecha_pedido->format('d/m/Y') }}
                            </td>

                            <td>

                                <a
                                    href="{{ route('pedidos.show', $pedido->id) }}"
                                    class="btn"
                                >
                                    Ver
                                </a>

                                <a
                                    href="{{ route('pedidos.edit', $pedido->id) }}"
                                    class="btn btn-primary"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('pedidos.destroy', $pedido->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este pedido?')"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>
                No tienes pedidos registrados todavía.
            </p>

        @endif

    </div>

@endsection