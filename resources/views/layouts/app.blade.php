<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistema de Pedidos')</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f6f8;
            color: #333;
        }

        nav {
            background-color: #1f2937;
            padding: 15px 30px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
        }

        .btn-success {
            background-color: #16a34a;
            color: white;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>

    <nav>
        <a href="{{ url('/') }}">Inicio</a>

        @auth
            <a href="{{ route('pedidos.index') }}">Pedidos</a>

            <span style="color: white; margin-right: 20px;">
                Hola, {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf

                <button type="submit"
                    class="btn"
                    style="background: transparent; color: white; padding: 0;">
                    Cerrar sesión
                </button>
            </form>
        @else
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('register') }}">Crear cuenta</a>
        @endauth
    </nav>

    <main class="container">
        @yield('content')
    </main>

</body>
</html>