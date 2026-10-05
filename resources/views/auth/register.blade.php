@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')

    <div class="card">

        <h1>Crear cuenta</h1>

        <p>Regístrate para administrar tus pedidos.</p>

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

        <form action="{{ route('register') }}" method="POST">

            @csrf

            <div>
                <label for="name">Nombre:</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <br>

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

            <div>
                <label for="password_confirmation">
                    Confirmar contraseña:
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                >
            </div>

            <br>

            <button type="submit" class="btn btn-success">
                Crear cuenta
            </button>

            <a href="{{ route('login') }}" class="btn">
                Ya tengo una cuenta
            </a>

        </form>

    </div>

@endsection