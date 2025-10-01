<?php

namespace App\DTO;

class RelatorioOutputDTO extends DTO
{
    public $result = [];

    public function __construct(array $dados)
    {
        foreach ($dados as $livros) {
            $livrosAutor = explode("|", $livros->livros);
            $livrosFormatados = [];
            foreach ($livrosAutor as $livro) {
                $dadosLivros = explode(",", $livro);
                $livrosFormatados[] = [
                    'codigo' => $dadosLivros[0],
                    'titulo' => $dadosLivros[1],
                    'editora' => $dadosLivros[2],
                    'edicao' => $dadosLivros[3],
                    'ano_publicacao' => $dadosLivros[4],
                    'valor' => $this->formatarValor($dadosLivros[5]),
                ];
            }
            $this->result[$livros->autor_nome] = $livrosFormatados;
        }
    }

    public function toArray() : array {
        return $this->result;
    }
}