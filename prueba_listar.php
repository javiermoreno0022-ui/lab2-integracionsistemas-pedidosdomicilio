<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controladores\PedidoController;
use App\Modelos\PedidoExpress;

try {
    $controller = new PedidoController();

    $pedidos = $controller->listar();

    if (empty($pedidos)) {
        echo "No hay pedidos registrados.";
        exit;
    }

    echo "===== LISTA DE PEDIDOS =====<br><br>";

    foreach ($pedidos as $pedido) {

        echo "ID: " . $pedido->getId() . "<br>";
        echo "Cliente: " . $pedido->getCliente() . "<br>";
        echo "Teléfono: " . $pedido->getTelefono() . "<br>";
        echo "Dirección: " . $pedido->getDireccion() . "<br>";
        echo "Producto: " . $pedido->getProducto() . "<br>";
        echo "Cantidad: " . $pedido->getCantidad() . "<br>";
        echo "Total: $" . number_format($pedido->getTotal(), 2) . "<br>";

        if ($pedido instanceof PedidoExpress) {
            echo "Costo express: $" .
                number_format($pedido->getCostoExpress(), 2) . "<br>";
        } else {
            echo "Costo express: $0.00<br>";
        }

        echo "Estado: " . $pedido->getEstado() . "<br>";
        echo "Fecha: " . $pedido->getFechaPedido() . "<br>";

        echo "-----------------------------<br>";
    }

} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}