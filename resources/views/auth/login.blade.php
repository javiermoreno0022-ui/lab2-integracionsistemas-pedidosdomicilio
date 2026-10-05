@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

    <div class="card">

        <h1>Iniciar sesión</h1>

        <p>Ingresa a tu cuenta para administrar tus pedidos.</p>

        @if ($errors->any())
            <div class="alert">
                <strong>No se pudo iniciar sesión:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">

            @csrf

            <div>
                <label for="email">Correo electrónico:</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <br>

            <div>
                <label for="password">Contraseña:</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <br>

            <button type="submit" class="btn btn-primary">
                Iniciar sesión
            </button>

            <a href="{{ route('register') }}" class="btn">
                Crear una cuenta
            </a>

        </form>

    </div>

@endsection