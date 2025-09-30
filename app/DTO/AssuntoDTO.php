<?php

namespace App\DTO;

use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AssuntoDTO extends DTO
{
    public $codigo;
    public $descricao;

    public function __construct(array $data)
    {
        return $this->validate($data);
    }

    private function validate(array $data): AssuntoDTO
    {

        $rules = [
            'codigo' => 'nullable|integer',
            'descricao' => 'required|string|max:20',
        ];

        $messages = [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser uma string.',
            'descricao.max' => 'A descrição não pode ter mais de 20 caracteres.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $this->codigo = $data['codigo'] ?? null;
        $this->descricao = $data['descricao'];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'descricao' => $this->descricao,
        ];
    }
}
