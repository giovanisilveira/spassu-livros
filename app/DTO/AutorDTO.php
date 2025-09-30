<?php

namespace App\DTO;

use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AutorDTO extends DTO
{
    public $codigo;
    public $nome;

    public function __construct(array $data)
    {
        return $this->validate($data);
    }

    private function validate(array $data): AutorDTO
    {

        $rules = [
            'codigo' => 'nullable|integer',
            'nome' => 'required|string|max:40',
        ];

        $messages = [
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser uma string.',
            'nome.max' => 'O nome não pode ter mais de 40 caracteres.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $this->codigo = $data['codigo'] ?? null;
        $this->nome = $data['nome'];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
        ];
    }
}
