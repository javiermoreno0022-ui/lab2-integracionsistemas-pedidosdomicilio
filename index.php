<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controladores\PedidoController;
use App\Modelos\Pedido;
use App\Modelos\PedidoExpress;

$controller = new PedidoController();

do {

    echo PHP_EOL;
    echo "========================================" . PHP_EOL;
    echo "    SISTEMA DE PEDIDOS A DOMICILIO" . PHP_EOL;
    echo "========================================" . PHP_EOL;
    echo "1. Registrar pedido" . PHP_EOL;
    echo "2. Listar pedidos" . PHP_EOL;
    echo "3. Buscar pedido" . PHP_EOL;
    echo "4. Actualizar pedido" . PHP_EOL;
    echo "5. Eliminar pedido" . PHP_EOL;
    echo "6. Salir" . PHP_EOL;
    echo "========================================" . PHP_EOL;

    $opcion = trim(readline("Seleccione una opción: "));

    switch ($opcion) {

       case '1':
    echo PHP_EOL;
    echo "========== REGISTRAR PEDIDO ==========" . PHP_EOL;

    try {
        echo "Cliente: ";
        $cliente = trim(readline());

        echo "Teléfono: ";
        $telefono = trim(readline());

        echo "Dirección: ";
        $direccion = trim(readline());

        echo "Producto: ";
        $producto = trim(readline());

        echo "Cantidad: ";
        $cantidad = trim(readline());

        echo "Total del pedido: ";
        $total = trim(readline());

        // Preguntar si el pedido será express
        do {
            $tipoEnvio = strtolower(
                trim(readline("¿Desea envío Express? (s/n): "))
            );

            if ($tipoEnvio !== 's' && $tipoEnvio !== 'n') {
                echo "Por favor, responda únicamente con 's' o 'n'." . PHP_EOL;
            }

        } while ($tipoEnvio !== 's' && $tipoEnvio !== 'n');

        // Costo del envío express
        $costoExpress = 0.00;

        if ($tipoEnvio === 's') {

            $entradaCosto = trim(
                readline("Costo Express [5.00]: ")
            );

            if ($entradaCosto === '') {
                $costoExpress = 5.00;
            } else {
                $costoExpress = (float)$entradaCosto;
            }
        }

        echo "Estado [Pendiente]: ";
        $estado = trim(readline());

        if ($estado === '') {
            $estado = 'Pendiente';
        }

        // Validaciones
        if (!is_numeric($cantidad) || (int)$cantidad <= 0) {
            echo "La cantidad debe ser un número mayor que cero." . PHP_EOL;
            break;
        }

        if (!is_numeric($total) || (float)$total < 0) {
            echo "El total no puede ser negativo." . PHP_EOL;
            break;
        }

        if ($costoExpress < 0) {
            echo "El costo Express no puede ser negativo." . PHP_EOL;
            break;
        }

        $cantidad = (int)$cantidad;
        $total = (float)$total;

        // Crear el tipo de pedido correspondiente
        if ($tipoEnvio === 's') {

            $pedido = new PedidoExpress(
                $cliente,
                $telefono,
                $direccion,
                $producto,
                $cantidad,
                $total,
                $costoExpress,
                null,
                $estado
            );

            $totalFinal = $pedido->calcularTotalExpress();

            $tipoPedido = "EXPRESS";

        } else {

            $pedido = new Pedido(
                $cliente,
                $telefono,
                $direccion,
                $producto,
                $cantidad,
                $total,
                null,
                $estado
            );

            $totalFinal = $total;

            $tipoPedido = "NORMAL";
        }

        // Mostrar resumen antes de guardar
        echo PHP_EOL;
        echo "========== RESUMEN DEL PEDIDO ==========" . PHP_EOL;
        echo "Cliente: " . $cliente . PHP_EOL;
        echo "Teléfono: " . $telefono . PHP_EOL;
        echo "Dirección: " . $direccion . PHP_EOL;
        echo "Producto: " . $producto . PHP_EOL;
        echo "Cantidad: " . $cantidad . PHP_EOL;
        echo "Tipo de envío: " . $tipoPedido . PHP_EOL;
        echo "Total del pedido: $" . number_format($total, 2) . PHP_EOL;
        echo "Costo Express: $" . number_format($costoExpress, 2) . PHP_EOL;
        echo "Total a pagar: $" . number_format($totalFinal, 2) . PHP_EOL;
        echo "Estado: " . $estado . PHP_EOL;
        echo "========================================" . PHP_EOL;

        // Confirmar registro
        $confirmacion = strtolower(
            trim(readline("¿Desea registrar este pedido? (s/n): "))
        );

        if ($confirmacion === 's') {

            if ($controller->crear($pedido)) {
                echo PHP_EOL;
                echo "Pedido registrado correctamente." . PHP_EOL;
            } else {
                echo PHP_EOL;
                echo "No se pudo registrar el pedido." . PHP_EOL;
            }

        } else {
            echo PHP_EOL;
            echo "Registro cancelado." . PHP_EOL;
        }

    } catch (InvalidArgumentException $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    }

    break;
            
         case '2':
    echo PHP_EOL;
    echo "========== LISTA DE PEDIDOS ==========" . PHP_EOL;

    try {
        $pedidos = $controller->listar();

        if (empty($pedidos)) {
            echo "No hay pedidos registrados." . PHP_EOL;
        } else {

            foreach ($pedidos as $pedido) {

                echo "----------------------------------------" . PHP_EOL;
                echo "ID: " . $pedido->getId() . PHP_EOL;
                echo "Cliente: " . $pedido->getCliente() . PHP_EOL;
                echo "Teléfono: " . $pedido->getTelefono() . PHP_EOL;
                echo "Dirección: " . $pedido->getDireccion() . PHP_EOL;
                echo "Producto: " . $pedido->getProducto() . PHP_EOL;
                echo "Cantidad: " . $pedido->getCantidad() . PHP_EOL;

                $total = $pedido->getTotal();

                if ($pedido instanceof PedidoExpress) {
                    $tipoEnvio = "EXPRESS";
                    $costoExpress = $pedido->getCostoExpress();
                    $totalFinal = $pedido->calcularTotalExpress();
                } else {
                    $tipoEnvio = "NORMAL";
                    $costoExpress = 0.00;
                    $totalFinal = $total;
                }

                echo "Tipo de envío: " . $tipoEnvio . PHP_EOL;
                echo "Total del pedido: $" .
                    number_format($total, 2) . PHP_EOL;
                echo "Costo Express: $" .
                    number_format($costoExpress, 2) . PHP_EOL;
                echo "Total a pagar: $" .
                    number_format($totalFinal, 2) . PHP_EOL;
                echo "Estado: " . $pedido->getEstado() . PHP_EOL;
                echo "Fecha: " .
                    ($pedido->getFechaPedido() ?? 'No disponible') .
                    PHP_EOL;
            }

            echo "----------------------------------------" . PHP_EOL;
            echo "Total de pedidos: " . count($pedidos) . PHP_EOL;
        }

    } catch (Exception $e) {
        echo "Error al listar los pedidos: " . $e->getMessage() . PHP_EOL;
    }

    break;

    case '3':
    echo PHP_EOL;
    echo "========== BUSCAR PEDIDO ==========" . PHP_EOL;

    try {
        $id = trim(readline("Ingrese el ID del pedido: "));

        if (!is_numeric($id) || (int)$id <= 0) {
            echo "El ID ingresado no es válido." . PHP_EOL;
            break;
        }

        $pedido = $controller->obtenerPorId((int)$id);

        if ($pedido === null) {
            echo PHP_EOL;
            echo "No se encontró un pedido con el ID " . $id . "." . PHP_EOL;
        } else {

            echo PHP_EOL;
            echo "========== PEDIDO ENCONTRADO ==========" . PHP_EOL;

            echo "ID: " . $pedido->getId() . PHP_EOL;
            echo "Cliente: " . $pedido->getCliente() . PHP_EOL;
            echo "Teléfono: " . $pedido->getTelefono() . PHP_EOL;
            echo "Dirección: " . $pedido->getDireccion() . PHP_EOL;
            echo "Producto: " . $pedido->getProducto() . PHP_EOL;
            echo "Cantidad: " . $pedido->getCantidad() . PHP_EOL;

            $total = $pedido->getTotal();

            if ($pedido instanceof PedidoExpress) {

                echo "Tipo de envío: EXPRESS" . PHP_EOL;

                echo "Costo Express: $" .
                    number_format(
                        $pedido->getCostoExpress(),
                        2
                    ) . PHP_EOL;

                echo "Total del pedido: $" .
                    number_format($total, 2) . PHP_EOL;

                echo "Total a pagar: $" .
                    number_format(
                        $pedido->calcularTotalExpress(),
                        2
                    ) . PHP_EOL;

            } else {

                echo "Tipo de envío: NORMAL" . PHP_EOL;
                echo "Costo Express: $0.00" . PHP_EOL;

                echo "Total del pedido: $" .
                    number_format($total, 2) . PHP_EOL;

                echo "Total a pagar: $" .
                    number_format($total, 2) . PHP_EOL;
            }

            echo "Estado: " . $pedido->getEstado() . PHP_EOL;

            echo "Fecha: " .
                ($pedido->getFechaPedido() ?? 'No disponible') .
                PHP_EOL;

            echo "========================================" . PHP_EOL;
        }

    } catch (InvalidArgumentException $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    }

    break;

        case '4':
    echo PHP_EOL;
    echo "========== ACTUALIZAR PEDIDO ==========" . PHP_EOL;

    try {
        $id = trim(readline("Ingrese el ID del pedido: "));

        if (!is_numeric($id) || (int)$id <= 0) {
            echo "El ID ingresado no es válido." . PHP_EOL;
            break;
        }

        $id = (int)$id;

        $pedidoActual = $controller->obtenerPorId($id);

        if ($pedidoActual === null) {
            echo "No existe un pedido con ese ID." . PHP_EOL;
            break;
        }

        // Mostrar información actual
        echo PHP_EOL;
        echo "========== DATOS ACTUALES ==========" . PHP_EOL;
        echo "ID: " . $pedidoActual->getId() . PHP_EOL;
        echo "Cliente: " . $pedidoActual->getCliente() . PHP_EOL;
        echo "Teléfono: " . $pedidoActual->getTelefono() . PHP_EOL;
        echo "Dirección: " . $pedidoActual->getDireccion() . PHP_EOL;
        echo "Producto: " . $pedidoActual->getProducto() . PHP_EOL;
        echo "Cantidad: " . $pedidoActual->getCantidad() . PHP_EOL;
        echo "Total: $" .
            number_format($pedidoActual->getTotal(), 2) .
            PHP_EOL;

        if ($pedidoActual instanceof PedidoExpress) {
            $costoActual = $pedidoActual->getCostoExpress();
            echo "Tipo de envío: EXPRESS" . PHP_EOL;
            echo "Costo Express: $" .
                number_format($costoActual, 2) .
                PHP_EOL;
        } else {
            $costoActual = 0.00;
            echo "Tipo de envío: NORMAL" . PHP_EOL;
            echo "Costo Express: $0.00" . PHP_EOL;
        }

        echo "Estado: " . $pedidoActual->getEstado() . PHP_EOL;
        echo "====================================" . PHP_EOL;

        echo PHP_EOL;
        echo "Ingrese los nuevos datos." . PHP_EOL;
        echo "Presione ENTER para mantener el valor actual." . PHP_EOL;
        echo PHP_EOL;

        $cliente = trim(readline(
            "Cliente [" . $pedidoActual->getCliente() . "]: "
        ));

        $telefono = trim(readline(
            "Teléfono [" . $pedidoActual->getTelefono() . "]: "
        ));

        $direccion = trim(readline(
            "Dirección [" . $pedidoActual->getDireccion() . "]: "
        ));

        $producto = trim(readline(
            "Producto [" . $pedidoActual->getProducto() . "]: "
        ));

        $cantidad = trim(readline(
            "Cantidad [" . $pedidoActual->getCantidad() . "]: "
        ));

        $total = trim(readline(
            "Total [" . $pedidoActual->getTotal() . "]: "
        ));

        $costoExpress = trim(readline(
            "Costo Express [" . $costoActual . "]: "
        ));

        $estado = trim(readline(
            "Estado [" . $pedidoActual->getEstado() . "]: "
        ));

        // Mantener valores actuales si se presiona ENTER
        if ($cliente === '') {
            $cliente = $pedidoActual->getCliente();
        }

        if ($telefono === '') {
            $telefono = $pedidoActual->getTelefono();
        }

        if ($direccion === '') {
            $direccion = $pedidoActual->getDireccion();
        }

        if ($producto === '') {
            $producto = $pedidoActual->getProducto();
        }

        if ($cantidad === '') {
            $cantidad = $pedidoActual->getCantidad();
        }

        if ($total === '') {
            $total = $pedidoActual->getTotal();
        }

        if ($costoExpress === '') {
            $costoExpress = $costoActual;
        }

        if ($estado === '') {
            $estado = $pedidoActual->getEstado();
        }

        // Validaciones
        if (!is_numeric($cantidad) || (int)$cantidad <= 0) {
            echo "La cantidad debe ser mayor que cero." . PHP_EOL;
            break;
        }

        if (!is_numeric($total) || (float)$total < 0) {
            echo "El total no puede ser negativo." . PHP_EOL;
            break;
        }

        if (!is_numeric($costoExpress) || (float)$costoExpress < 0) {
            echo "El costo Express no puede ser negativo." . PHP_EOL;
            break;
        }

        $cantidad = (int)$cantidad;
        $total = (float)$total;
        $costoExpress = (float)$costoExpress;

        // Crear nuevamente el objeto correspondiente
        if ($costoExpress > 0) {

            $pedido = new PedidoExpress(
                $cliente,
                $telefono,
                $direccion,
                $producto,
                $cantidad,
                $total,
                $costoExpress,
                $id,
                $estado,
                $pedidoActual->getFechaPedido()
            );

        } else {

            $pedido = new Pedido(
                $cliente,
                $telefono,
                $direccion,
                $producto,
                $cantidad,
                $total,
                $id,
                $estado,
                $pedidoActual->getFechaPedido()
            );
        }

        // Mostrar resumen de cambios
        echo PHP_EOL;
        echo "========== RESUMEN DE CAMBIOS ==========" . PHP_EOL;
        echo "Cliente: " . $cliente . PHP_EOL;
        echo "Teléfono: " . $telefono . PHP_EOL;
        echo "Dirección: " . $direccion . PHP_EOL;
        echo "Producto: " . $producto . PHP_EOL;
        echo "Cantidad: " . $cantidad . PHP_EOL;
        echo "Total: $" . number_format($total, 2) . PHP_EOL;

        if ($pedido instanceof PedidoExpress) {
            echo "Tipo de envío: EXPRESS" . PHP_EOL;
            echo "Costo Express: $" .
                number_format($costoExpress, 2) .
                PHP_EOL;
            echo "Total a pagar: $" .
                number_format(
                    $pedido->calcularTotalExpress(),
                    2
                ) .
                PHP_EOL;
        } else {
            echo "Tipo de envío: NORMAL" . PHP_EOL;
            echo "Costo Express: $0.00" . PHP_EOL;
            echo "Total a pagar: $" .
                number_format($total, 2) .
                PHP_EOL;
        }

        echo "Estado: " . $estado . PHP_EOL;
        echo "========================================" . PHP_EOL;

        $confirmacion = strtolower(
            trim(readline("¿Confirmar los cambios? (s/n): "))
        );

        if ($confirmacion === 's') {

            if ($controller->editar($pedido)) {
                echo PHP_EOL;
                echo "Pedido actualizado correctamente." . PHP_EOL;
            } else {
                echo PHP_EOL;
                echo "No se pudo actualizar el pedido." . PHP_EOL;
            }

        } else {
            echo PHP_EOL;
            echo "Actualización cancelada." . PHP_EOL;
        }

    } catch (InvalidArgumentException $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    }

    break;

        case '5':
    echo PHP_EOL;
    echo "========== ELIMINAR PEDIDO ==========" . PHP_EOL;

    try {
        $id = trim(readline("Ingrese el ID del pedido: "));

        if (!is_numeric($id) || (int)$id <= 0) {
            echo "El ID ingresado no es válido." . PHP_EOL;
            break;
        }

        $id = (int)$id;

        $pedido = $controller->obtenerPorId($id);

        if ($pedido === null) {
            echo "No existe un pedido con ese ID." . PHP_EOL;
            break;
        }

        // Mostrar el pedido antes de eliminarlo
        echo PHP_EOL;
        echo "========== PEDIDO A ELIMINAR ==========" . PHP_EOL;
        echo "ID: " . $pedido->getId() . PHP_EOL;
        echo "Cliente: " . $pedido->getCliente() . PHP_EOL;
        echo "Teléfono: " . $pedido->getTelefono() . PHP_EOL;
        echo "Producto: " . $pedido->getProducto() . PHP_EOL;
        echo "Cantidad: " . $pedido->getCantidad() . PHP_EOL;

        if ($pedido instanceof PedidoExpress) {
            echo "Tipo de envío: EXPRESS" . PHP_EOL;
            echo "Costo Express: $" .
                number_format(
                    $pedido->getCostoExpress(),
                    2
                ) . PHP_EOL;
        } else {
            echo "Tipo de envío: NORMAL" . PHP_EOL;
            echo "Costo Express: $0.00" . PHP_EOL;
        }

        echo "Total: $" .
            number_format($pedido->getTotal(), 2) .
            PHP_EOL;

        echo "Estado: " . $pedido->getEstado() . PHP_EOL;
        echo "========================================" . PHP_EOL;

        $confirmacion = strtolower(
            trim(readline("¿Está seguro de eliminar este pedido? (s/n): "))
        );

        if ($confirmacion === 's') {

            if ($controller->eliminar($id)) {
                echo PHP_EOL;
                echo "Pedido eliminado correctamente." . PHP_EOL;
            } else {
                echo PHP_EOL;
                echo "No se pudo eliminar el pedido." . PHP_EOL;
            }

        } else {
            echo PHP_EOL;
            echo "Operación cancelada." . PHP_EOL;
        }

    } catch (InvalidArgumentException $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    }

    break;

        case '6':
            echo PHP_EOL;
            echo "Gracias por utilizar el Sistema de Pedidos a Domicilio." . PHP_EOL;
            break;

        default:
            echo PHP_EOL;
            echo "Opción no válida. Intente nuevamente." . PHP_EOL;
            break;
    }

} while ($opcion !== '6');