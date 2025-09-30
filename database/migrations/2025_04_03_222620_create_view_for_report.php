<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('
            CREATE VIEW autores_livros AS
            SELECT
                autor.codau AS autor_id,
                autor.nome AS autor_nome,
                livro.codl AS livro_id,
                livro.titulo AS livro_titulo,
                livro.editora AS livro_editora,
                livro.edicao AS livro_edicao,
                livro.anopublicacao AS livro_anopublicacao,
                livro.valor AS livro_valor
            FROM
                autor
            JOIN
                livro_autor ON autor.codau = livro_autor.autor_codau
            JOIN
                livro ON livro_autor.livro_codl = livro.codl;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS autores_livros');
    }
};
