<?php

namespace App\Modelos;

class Pedido
{
    private ?int $id;
    private string $cliente;
    private string $telefono;
    private string $direccion;
    private string $producto;
    private int $cantidad;
    private float $total;
    private string $estado;
    private ?string $fechaPedido;

    public function __construct(
        string $cliente,
        string $telefono,
        string $direccion,
        string $producto,
        int $cantidad,
        float $total,
        ?int $id = null,
        string $estado = 'Pendiente',
        ?string $fechaPedido = null
    ) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->total = $total;
        $this->estado = $estado;
        $this->fechaPedido = $fechaPedido;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCliente(): string
    {
        return $this->cliente;
    }

    public function setCliente(string $cliente): void
    {
        $this->cliente = $cliente;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    public function getProducto(): string
    {
        return $this->producto;
    }

    public function setProducto(string $producto): void
    {
        $this->producto = $producto;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getFechaPedido(): ?string
    {
        return $this->fechaPedido;
    }

    public function setFechaPedido(?string $fechaPedido): void
    {
        $this->fechaPedido = $fechaPedido;
    }

    public function cambiarEstado(string $nuevoEstado): void
    {
        $this->estado = $nuevoEstado;
    }

    public function marcarComoEntregado(): void
    {
        $this->estado = 'Entregado';
    }
}