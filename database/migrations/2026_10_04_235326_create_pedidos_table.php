<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('cliente', 100);
            $table->string('telefono', 20);
            $table->text('direccion');
            $table->string('producto', 150);
            $table->unsignedInteger('cantidad');
            $table->decimal('total', 10, 2);
            $table->string('estado', 30)->default('Pendiente');
            $table->decimal('costo_express', 10, 2)->default(5.00);
            $table->date('fecha_pedido');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
