<?php

namespace App\Repositorios;

use App\BaseDatos\Conexion;
use App\Modelos\Pedido;
use App\Modelos\PedidoExpress;
use PDO;
use InvalidArgumentException;

class PedidoRepository
{
    private PDO $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::obtener();
    }

    /**
     * Crear un nuevo pedido.
     */
    public function crear(Pedido $pedido): bool
    {
        $costoExpress = 0.00;

        if ($pedido instanceof PedidoExpress) {
            $costoExpress = $pedido->getCostoExpress();
        }

        if ($costoExpress < 0) {
            throw new InvalidArgumentException(
                'El costo express no puede ser negativo.'
            );
        }

        $sql = "INSERT INTO pedidos
                (cliente, telefono, direccion, producto, cantidad, total, costo_express, estado)
                VALUES
                (:cliente, :telefono, :direccion, :producto, :cantidad, :total, :costo_express, :estado)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':cliente' => $pedido->getCliente(),
            ':telefono' => $pedido->getTelefono(),
            ':direccion' => $pedido->getDireccion(),
            ':producto' => $pedido->getProducto(),
            ':cantidad' => $pedido->getCantidad(),
            ':total' => $pedido->getTotal(),
            ':costo_express' => $costoExpress,
            ':estado' => $pedido->getEstado()
        ]);
    }

    /**
     * Obtener todos los pedidos.
     *
     * @return Pedido[]
     */
    public function obtenerTodos(): array
    {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";

        $stmt = $this->conexion->query($sql);

        $resultados = $stmt->fetchAll();

        $pedidos = [];

        foreach ($resultados as $fila) {
            $pedidos[] = $this->convertirAObjeto($fila);
        }

        return $pedidos;
    }

    /**
     * Obtener un pedido por su ID.
     */
    public function obtenerPorId(int $id): ?Pedido
    {
        if ($id <= 0) {
            throw new InvalidArgumentException(
                'El ID debe ser mayor que cero.'
            );
        }

        $sql = "SELECT * FROM pedidos WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return $this->convertirAObjeto($fila);
    }

    /**
     * Actualizar un pedido existente.
     */
    public function actualizar(Pedido $pedido): bool
    {
        $id = $pedido->getId();

        if ($id === null || $id <= 0) {
            throw new InvalidArgumentException(
                'El ID del pedido no es válido.'
            );
        }

        $costoExpress = 0.00;

        if ($pedido instanceof PedidoExpress) {
            $costoExpress = $pedido->getCostoExpress();
        }

        if ($costoExpress < 0) {
            throw new InvalidArgumentException(
                'El costo express no puede ser negativo.'
            );
        }

        $sql = "UPDATE pedidos SET
                    cliente = :cliente,
                    telefono = :telefono,
                    direccion = :direccion,
                    producto = :producto,
                    cantidad = :cantidad,
                    total = :total,
                    costo_express = :costo_express,
                    estado = :estado
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':cliente' => $pedido->getCliente(),
            ':telefono' => $pedido->getTelefono(),
            ':direccion' => $pedido->getDireccion(),
            ':producto' => $pedido->getProducto(),
            ':cantidad' => $pedido->getCantidad(),
            ':total' => $pedido->getTotal(),
            ':costo_express' => $costoExpress,
            ':estado' => $pedido->getEstado(),
            ':id' => $id
        ]);
    }

    /**
     * Eliminar un pedido.
     */
    public function eliminar(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException(
                'El ID debe ser mayor que cero.'
            );
        }

        $sql = "DELETE FROM pedidos WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    /**
     * Convertir un registro de la base de datos
     * en un objeto Pedido o PedidoExpress.
     */
    private function convertirAObjeto(array $fila): Pedido
    {
        $costoExpress = (float) ($fila['costo_express'] ?? 0);

        if ($costoExpress > 0) {
            return new PedidoExpress(
                $fila['cliente'],
                $fila['telefono'],
                $fila['direccion'],
                $fila['producto'],
                (int) $fila['cantidad'],
                (float) $fila['total'],
                $costoExpress,
                (int) $fila['id'],
                $fila['estado'],
                $fila['fecha_pedido']
            );
        }

        return new Pedido(
            $fila['cliente'],
            $fila['telefono'],
            $fila['direccion'],
            $fila['producto'],
            (int) $fila['cantidad'],
            (float) $fila['total'],
            (int) $fila['id'],
            $fila['estado'],
            $fila['fecha_pedido']
        );
    }
}