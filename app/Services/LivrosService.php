<?php

namespace App\Services;

use App\DTO\LivroDTO;
use App\DTO\LivroOutputDTO;
use App\Models\Livro;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class LivrosService
{
    protected $livroModel;

    public function __construct(Livro $livro)
    {
        $this->livroModel = $livro;
    }

    /**
     * Inicializador do service
     */
    static public function init(): LivrosService
    {
        return new LivrosService(
            new Livro()
        );
    }

    /**
     * Método responsável por salvar os dados de um livro
     */
    public function save(LivroDTO $livroDTO)
    {
        DB::beginTransaction();
        try {
            $consulta = $this->livroModel->where('titulo', $livroDTO->titulo);

            // Inserção
            if (empty($livroDTO->codigo)) {
                if (!$consulta->get()->isEmpty()) {
                    throw new InvalidArgumentException("Um livro com o título '$livroDTO->titulo' já consta no cadastro.");
                }

                $livro = $this->livroModel->create($livroDTO->toArray());
            }

            // Alteração
            if (!empty($livroDTO->codigo)) {
                $consulta->where('codl', '!=', $livroDTO->codigo);
                if (!$consulta->get()->isEmpty()) {
                    throw new InvalidArgumentException("Um livro com o título '$livroDTO->titulo' já consta no cadastro.");
                }

                $livro = $this->livroModel->find($livroDTO->codigo);
                $livro->update($livroDTO->toArray());
            }

            $livro->autores()->sync($livroDTO->autor);
            $livro->assuntos()->sync($livroDTO->assunto);

            DB::commit();
            return $livro;
        } catch (Exception $e) {
            DB::rollBack();
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Método responsável por retornar os dados de livros
     */
    public function list(string $search, int $page = 1, int $qtdItens = 50)
    {
        $livrosQuery = $this->livroModel->query();
        $livrosQuery->orderBy('titulo', 'asc');

        if (!empty($search)) {
            $livrosQuery->where('titulo', 'like', "%$search%");
        }

        $livros = $livrosQuery->with(['assuntos'])->paginate(
            $qtdItens,
            ['*'],
            'page',
            $page
        );

        if ($livros->isEmpty() && $page > 1) {
            throw new RuntimeException("Não há itens na página #$page.");
        }

        $result = LivroOutputDTO::fromArray($livros);

        return $result;
    }

    /**
     * Método responsável por recuperar um livro a partir do código informado
     */
    public function getById(int $id, $with = [])
    {
        if (empty($with)) {
            return LivroOutputDTO::fromObject($this->findById($id));
        }

        return LivroOutputDTO::fromObject($this->findById($id, $with));
    }

    /**
     * Método interno do serviço que recupera os dados de um livro sem formatação
     */
    private function findById($id, $with = [])
    {
        if (empty($id)) {
            return;
        }

        if (empty($with)) {
            $livro = $this->livroModel->find($id);
        }

        if (!empty($with)) {
            $livro = $this->livroModel->with($with)->find($id);
        }

        if (!$livro) {
            throw new RuntimeException("O livro de código #$id não foi encontrado.");
        }

        return $livro;
    }

    /**
     * Método responsável por remover os dados de um livro
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $livro = $this->findById($id);
            if (!$livro) {
                throw new RuntimeException("Não possível remover o livro #$id");
            }

            $livro->autores()->detach();
            $livro->assuntos()->detach();
            $livro->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new RuntimeException($e);
        }
    }

    /**
     * Método responsável por consultar a view que possui os dados para gerar o
     * relatório de livros por autor
     */
    public function relatorio()
    {
        $livrosPorAutor = DB::table('autores_livros')
        ->orderBy('autor_nome', 'asc')
        ->get();

        return $livrosPorAutor->groupBy('autor_nome');
    }
}
