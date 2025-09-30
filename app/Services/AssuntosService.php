<?php

namespace App\Services;

use App\DTO\AssuntoDTO;
use App\DTO\AssuntoOutputDTO;
use App\Models\Assunto;
use App\Models\LivroAssunto;
use InvalidArgumentException;
use RuntimeException;

class AssuntosService
{
    protected $assuntoModel;
    protected $livroAssuntoModel;

    public function __construct(Assunto $assunto, LivroAssunto $livroAssunto)
    {
        $this->assuntoModel = $assunto;
        $this->livroAssuntoModel = $livroAssunto;
    }

    /**
     * Inicializador do service
     */
    static public function init(): AssuntosService
    {
        return new AssuntosService(
            new Assunto(),
            new LivroAssunto()
        );
    }

    /**
     * Método responsável por registrar um Assunto de livro
     */
    public function save(AssuntoDTO $assuntoDTO)
    {
        $consulta = $this->assuntoModel->where('descricao', $assuntoDTO->descricao);

        if (empty($assuntoDTO->codigo)) {
            if (!$consulta->get()->isEmpty()) {
                throw new InvalidArgumentException("Um assunto com a descrição '$assuntoDTO->descricao' já consta no cadastro.");
            }
            return $this->assuntoModel->create($assuntoDTO->toArray());
        }

        $consulta->where('codas', '!=', $assuntoDTO->codigo);
        if (!$consulta->get()->isEmpty()) {
            throw new InvalidArgumentException("Um assunto com a descrição '$assuntoDTO->descricao' já consta no cadastro.");
        }

        $assunto = $this->assuntoModel->find($assuntoDTO->codigo);
        return $assunto->update($assuntoDTO->toArray());
    }

    /**
     * Método responsável por recuperar os dados dos assuntos
     */
    public function list(string $search, int $page = 1, int $qtdItens = 50)
    {
        $assuntosQuery = $this->assuntoModel->query();
        $assuntosQuery->orderBy('descricao', 'asc');

        if (!empty($search)) {
            $assuntosQuery->where('descricao', 'like', "%$search%");
        }

        $assuntos = $assuntosQuery->paginate(
            $qtdItens,
            ['*'],
            'page',
            $page
        );

        if ($assuntos->isEmpty() && $page > 1) {
            throw new RuntimeException("Não há itens na página #$page.");
        }

        return AssuntoOutputDTO::fromArray($assuntos);
    }

    /**
     * Método responsável por recuperar um assunto pelo código
     */
    public function getById(int $id)
    {
        return AssuntoOutputDTO::fromObject($this->findById($id));
    }

    /**
     * Método responsável por recuperar um assunto sem formatação
     */
    private function findById($id)
    {
        if (empty($id)) {
            return;
        }

        $assunto = $this->assuntoModel->find($id);

        if (!$assunto) {
            throw new RuntimeException("O assunto de código #$id não foi encontrado.");
        }

        return $assunto;
    }

    /**
     * Método responsável por remover um assunto
     */
    public function delete($id)
    {
        $assunto = $this->findById($id);
        if (!$assunto) {
            throw new RuntimeException("Não possível remover o assunto #$id");
        }

        if (!$this->livroAssuntoModel->where('assunto_codas', $id)->get()->isEmpty()) {
            throw new RuntimeException("Não é possível remover o assunto #$id, há um livro vinculado a ele.");
        }

        return $assunto->delete();
    }

    /**
     * Método responsável por recuperar todos os assuntos
     */
    public function listAll()
    {
        $assuntos = $this->assuntoModel->orderBy('descricao', 'asc')->get();

        $result = $assuntos->map(function ($assunto) {
            return [
                "codigo" => $assunto->codas,
                "descricao" => $assunto->descricao,
            ];
        });

        return $result;
    }
}
