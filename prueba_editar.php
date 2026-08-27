<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controladores\PedidoController;
use App\Modelos\PedidoExpress;

try {
    $controller = new PedidoController();

    // El pedido que creamos anteriormente tiene ID 1.
    $pedido = new PedidoExpress(
        'Maximiliano García EDITADO',
        '7111-1111',
        'San Salvador, El Salvador',
        'Pizza familiar',
        3,
        25.00,
        3.50,
        1,
        'En preparación'
    );

    $resultado = $controller->editar($pedido);

    if ($resultado) {
        echo "¡Pedido actualizado correctamente!<br><br>";

        echo "ID: " . $pedido->getId() . "<br>";
        echo "Cliente: " . $pedido->getCliente() . "<br>";
        echo "Teléfono: " . $pedido->getTelefono() . "<br>";
        echo "Dirección: " . $pedido->getDireccion() . "<br>";
        echo "Producto: " . $pedido->getProducto() . "<br>";
        echo "Cantidad: " . $pedido->getCantidad() . "<br>";
        echo "Total: $" . number_format($pedido->getTotal(), 2) . "<br>";
        echo "Costo express: $" . number_format($pedido->getCostoExpress(), 2) . "<br>";
        echo "Estado: " . $pedido->getEstado() . "<br>";
    } else {
        echo "No se pudo actualizar el pedido.";
    }

} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}