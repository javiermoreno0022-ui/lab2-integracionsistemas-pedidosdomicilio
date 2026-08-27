<?php

namespace App\Controladores;

use App\Modelos\Pedido;
use App\Repositorios\PedidoRepository;
use InvalidArgumentException;

class PedidoController
{
    private PedidoRepository $repositorio;

    public function __construct()
    {
        $this->repositorio = new PedidoRepository();
    }

    /**
     * Crear un pedido.
     */
    public function crear(Pedido $pedido): bool
    {
        $this->validarPedido($pedido);

        return $this->repositorio->crear($pedido);
    }

    /**
     * Listar todos los pedidos.
     */
    public function listar(): array
    {
        return $this->repositorio->obtenerTodos();
    }

    /**
     * Obtener un pedido específico.
     */
    public function obtenerPorId(int $id): ?Pedido
    {
        if ($id <= 0) {
            throw new InvalidArgumentException(
                'El ID debe ser mayor que cero.'
            );
        }

        return $this->repositorio->obtenerPorId($id);
    }

    /**
     * Editar un pedido.
     */
    public function editar(Pedido $pedido): bool
    {
        $this->validarPedido($pedido);

        if ($pedido->getId() === null || $pedido->getId() <= 0) {
            throw new InvalidArgumentException(
                'El ID del pedido no es válido.'
            );
        }

        return $this->repositorio->actualizar($pedido);
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

        return $this->repositorio->eliminar($id);
    }

    /**
     * Validaciones básicas del pedido.
     */
    private function validarPedido(Pedido $pedido): void
    {
        if (trim($pedido->getCliente()) === '') {
            throw new InvalidArgumentException(
                'El cliente no puede estar vacío.'
            );
        }

        if (trim($pedido->getTelefono()) === '') {
            throw new InvalidArgumentException(
                'El teléfono no puede estar vacío.'
            );
        }

        if (trim($pedido->getDireccion()) === '') {
            throw new InvalidArgumentException(
                'La dirección no puede estar vacía.'
            );
        }

        if (trim($pedido->getProducto()) === '') {
            throw new InvalidArgumentException(
                'El producto no puede estar vacío.'
            );
        }

        if ($pedido->getCantidad() <= 0) {
            throw new InvalidArgumentException(
                'La cantidad debe ser mayor que cero.'
            );
        }

        if ($pedido->getTotal() < 0) {
            throw new InvalidArgumentException(
                'El total no puede ser negativo.'
            );
        }

        if (trim($pedido->getEstado()) === '') {
            throw new InvalidArgumentException(
                'El estado no puede estar vacío.'
            );
        }
    }
}