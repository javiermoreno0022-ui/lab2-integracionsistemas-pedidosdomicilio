<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controladores\PedidoController;

try {
    $controller = new PedidoController();

    // El pedido que hemos estado utilizando tiene ID 1.
    $id = 1;

    // Comprobar primero que exista.
    $pedido = $controller->obtenerPorId($id);

    if ($pedido === null) {
        echo "El pedido con ID $id no existe.";
        exit;
    }

    echo "Pedido encontrado:<br>";
    echo "ID: " . $pedido->getId() . "<br>";
    echo "Cliente: " . $pedido->getCliente() . "<br>";
    echo "Producto: " . $pedido->getProducto() . "<br>";
    echo "Costo express: $"
        . number_format(
            $pedido instanceof \App\Modelos\PedidoExpress
                ? $pedido->getCostoExpress()
                : 0,
            2
        )
        . "<br><br>";

    // Eliminar.
    $resultado = $controller->eliminar($id);

    if ($resultado) {
        echo "¡Pedido eliminado correctamente!<br>";

        // Comprobar que ya no exista.
        $pedidoEliminado = $controller->obtenerPorId($id);

        if ($pedidoEliminado === null) {
            echo "✓ Confirmación: el pedido ya no existe en la base de datos.";
        } else {
            echo "⚠ El pedido todavía existe.";
        }
    } else {
        echo "No se pudo eliminar el pedido.";
    }

} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}