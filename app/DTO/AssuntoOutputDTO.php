<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AssuntoOutputDTO extends DTO
{
    public $codigo;
    public $descricao;

    public function __construct(
        int $codigo,
        string $descricao,
    ) {
        $this->codigo = $codigo;
        $this->descricao = $descricao;
    }

    public static function fromObject($assunto)
    {

        return (new self(
            $assunto->codas ?? 0,
            $assunto->descricao ?? '',
        ))->toArray();
    }

    public static function fromArray($data)
    {
        return $data->map(function ($assunto) {
            return self::fromObject($assunto);
        });
    }

    public function toArray(): array
    {
        return [
            "codigo" => $this->codigo,
            "descricao" => $this->descricao,
        ];
    }
}
