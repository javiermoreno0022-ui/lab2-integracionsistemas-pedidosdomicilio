<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controladores\PedidoController;
use App\Modelos\PedidoExpress;

try {
    $controller = new PedidoController();

    $pedido = new PedidoExpress(
        'Maximiliano García',
        '7000-0000',
        'San Salvador',
        'Hamburguesa',
        2,
        12.00,
        2.50
    );

    $resultado = $controller->crear($pedido);

    if ($resultado) {
        echo "¡Pedido creado correctamente!<br>";
        echo "Cliente: " . $pedido->getCliente() . "<br>";
        echo "Producto: " . $pedido->getProducto() . "<br>";
        echo "Cantidad: " . $pedido->getCantidad() . "<br>";
        echo "Total: $" . number_format($pedido->getTotal(), 2) . "<br>";
        echo "Costo express: $" . number_format($pedido->getCostoExpress(), 2) . "<br>";
        echo "Estado: " . $pedido->getEstado() . "<br>";
    } else {
        echo "No se pudo crear el pedido.";
    }

} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}