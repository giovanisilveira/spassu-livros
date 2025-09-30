<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AutorOutputDTO extends DTO
{
    public $codigo;
    public $nome;

    public function __construct(
        int $codigo,
        string $nome,
    ) {
        $this->codigo = $codigo;
        $this->nome = $nome;
    }

    public static function fromObject($autor)
    {

        return (new self(
            $autor->codau ?? 0,
            $autor->nome ?? '',
        ))->toArray();
    }

    public static function fromArray($data)
    {
        return $data->map(function ($autor) {
            return self::fromObject($autor);
        });
    }

    public function toArray(): array
    {
        return [
            "codigo" => $this->codigo,
            "nome" => $this->nome,
        ];
    }
}
