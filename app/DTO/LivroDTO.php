<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class LivroDTO extends DTO
{
    public $codigo;
    public $titulo;
    public $editora;
    public $edicao;
    public $anopublicacao;
    public $valor;
    public $autor;
    public $assunto;

    public function __construct(array $data)
    {
        return $this->validate($data);
    }

    private function validate(array $data): LivroDTO
    {
        if (isset($data['valor'])) {
            $data['valor'] = $this->normalizeValor($data['valor']);
        }

        $rules = [
            'codigo' => 'nullable|integer',
            'titulo' => 'required|string|max:40',
            'editora' => 'required|string|max:40',
            'edicao' => 'required|integer|min:1',
            'anopublicacao' => 'required|digits:4|numeric|min:1900|max:' . Carbon::now()->year,
            'valor' => 'required|integer',
            'autor' => 'required|array',
            'assunto' => 'required|array',
        ];

        $messages = [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.string' => 'O título deve ser uma string.',
            'titulo.max' => 'O título não pode ter mais de 40 caracteres.',

            'editora.required' => 'A editora é obrigatória.',
            'editora.string' => 'A editora deve ser uma string.',
            'editora.max' => 'A editora não pode ter mais de 40 caracteres.',

            'edicao.required' => 'A edição é obrigatória.',
            'edicao.integer' => 'A edição deve ser um número inteiro.',
            'edicao.min' => 'A edição deve ser maior que 0.',

            'anopublicacao.required' => 'O ano de publicação é obrigatório.',
            'anopublicacao.digits' => 'O ano de publicação deve ser um ano válido (ex: ' . Carbon::now()->year . ').',
            'anopublicacao.min' => 'O ano de publicação deve ser superior a 1900.',
            'anopublicacao.max' => 'O ano de publicação não pode ser superior a ' . Carbon::now()->year . '.',

            'valor.required' => 'O valor é obrigatório.',
            'valor.integer' => 'O valor deve ser um número.',

            'autor.required' => 'O autor é obrigatório.',
            'autor.array' => 'O autor deve ser um array.',

            'assunto.required' => 'O assunto é obrigatório.',
            'assunto.array' => 'O assunto deve ser um array.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $this->codigo = $data['codigo'] ?? null;
        $this->titulo = $data['titulo'];
        $this->editora = $data['editora'];
        $this->edicao = $data['edicao'];
        $this->anopublicacao = $data['anopublicacao'];
        $this->valor = $data['valor'];
        $this->autor = $data['autor'];
        $this->assunto = $data['assunto'];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'codigo' => $this->codigo,
            'titulo' => $this->titulo,
            'editora' => $this->editora,
            'edicao' => $this->edicao,
            'anopublicacao' => $this->anopublicacao,
            'valor' => $this->valor,
            'autor' => $this->autor,
            'assunto' => $this->assunto,
        ];
    }
}
