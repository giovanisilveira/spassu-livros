<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class LivroOutputDTO extends DTO
{
    public $codigo;
    public $titulo;
    public $editora;
    public $edicao;
    public $anopublicacao;
    public $valor;
    public $autores;
    public $assuntos;

    public function __construct(
        int $codigo,
        string $titulo,
        string $editora,
        int $edicao,
        int $anopublicacao,
        int $valor,
        array $autores,
        array $assuntos
    ) {
        $this->codigo = $codigo;
        $this->titulo = $titulo;
        $this->editora = $editora;
        $this->edicao = $edicao;
        $this->anopublicacao = $anopublicacao;
        $this->valor = $this->formatarValor($valor);
        $this->autores = $autores;
        $this->assuntos = $assuntos;
    }

    public static function fromObject($livro)
    {

        return (new self(
            $livro->codl ?? 0,
            $livro->titulo ?? '',
            $livro->editora ?? '',
            $livro->edicao ?? 0,
            $livro->anopublicacao ?? 0,
            $livro->valor ?? 0,
            isset($livro->autores) ? $livro->autores->toArray() : [],
            isset($livro->assuntos) ? $livro->assuntos->toArray() : []
        ))->toArray();
    }

    public static function fromArray($data)
    {
        return $data->map(function ($livro) {
            return self::fromObject($livro);
        });
    }

    public function toArray(): array
    {
        return [
            "codigo" => $this->codigo,
            "titulo" => $this->titulo,
            "editora" => $this->editora,
            "edicao" => $this->edicao,
            "anopublicacao" => $this->anopublicacao,
            "valor" => $this->valor,
            "autores" => $this->autores,
            "assuntos" => $this->assuntos,
        ];
    }
}
