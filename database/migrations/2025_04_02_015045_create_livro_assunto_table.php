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
        Schema::create('livro_assunto', function (Blueprint $table) {
            $table->bigInteger('livro_codl')->unsigned();
            $table->bigInteger('assunto_codas')->unsigned();

            $table->primary(['livro_codl', 'assunto_codas']);

            $table->foreign('livro_codl')
                  ->references('codl')->on('livro')
                  ->onDelete('restrict');

            $table->foreign('assunto_codas')
                  ->references('codas')->on('assunto')
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
        Schema::dropIfExists('livro_assunto');
    }
};
