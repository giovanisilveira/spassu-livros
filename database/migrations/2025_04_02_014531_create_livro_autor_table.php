<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->bigInteger('livro_codl')->unsigned();
            $table->bigInteger('autor_codau')->unsigned();

            $table->primary(['livro_codl', 'autor_codau']);

            $table->foreign('livro_codl')
                  ->references('codl')->on('livro')
                  ->onDelete('restrict');

            $table->foreign('autor_codau')
                  ->references('codau')->on('autor')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livro_autor');
    }
};
