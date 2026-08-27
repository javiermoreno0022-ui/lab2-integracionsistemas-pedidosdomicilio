<?php

namespace App\Modelos;

use App\Interfaces\Entregable;

class PedidoExpress extends Pedido implements Entregable
{
    private float $costoExpress;

    public function __construct(
        string $cliente,
        string $telefono,
        string $direccion,
        string $producto,
        int $cantidad,
        float $total,
        float $costoExpress = 5.00,
        ?int $id = null,
        string $estado = 'Pendiente',
        ?string $fechaPedido = null
    ) {
        parent::__construct(
            $cliente,
            $telefono,
            $direccion,
            $producto,
            $cantidad,
            $total,
            $id,
            $estado,
            $fechaPedido
        );

        $this->costoExpress = $costoExpress;
    }

    public function getCostoExpress(): float
    {
        return $this->costoExpress;
    }

    public function setCostoExpress(float $costoExpress): void
    {
        $this->costoExpress = $costoExpress;
    }

    public function calcularTotalExpress(): float
    {
        return $this->getTotal() + $this->costoExpress;
    }

    public function entregar(): void
    {
        $this->marcarComoEntregado();
    }
}