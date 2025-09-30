<?php

namespace App\Http\Controllers;

use App\DTO\LivroDTO;
use App\Services\AssuntosService;
use App\Services\AutoresService;
use App\Services\LivrosService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LivrosController extends Controller
{
    public function index(Request $request)
    {
        try{
            $search = $request->input('search') ?? '';

            $livros = LivrosService::init()->list(
                $search,
                $request->input('page') ?? 1
            ) ?? [];

            return view('livros', [
                'livros' => $livros,
                'search' => $search
            ]);
        }catch(Exception $e){
            return redirect()
                ->route('livros')
                ->with('error', $e->getMessage());
        }
    }

    public function formulario($id = null, Request $request)
    {
        try{
            $autores = AutoresService::init()->listAll();
            $assuntos = AssuntosService::init()->listAll();
            $livro = LivrosService::init()->getById((int) $id, ['autores:codau,nome', 'assuntos:codas,descricao']);

            return view('livrosform', [
                'livro' => $livro,
                'autores' => $autores,
                'assuntos' => $assuntos
            ]);
        }catch(Exception $e){
            return redirect()
                ->route('livros')
                ->with('error', $e->getMessage())
                ->with('errorData', $request->all());
        }
    }

    public function salvar(Request $request)
    {
        try {
            $livroDTO = (new LivroDTO($request->all()));

            LivrosService::init()->save($livroDTO);

            return redirect()
                ->route('livros')
                ->with('success', 'Livro salvo com sucesso!');
        } catch (Exception $e) {
            return redirect()
                ->route('livrosform')
                ->with('error', $e->getMessage())
                ->with('errorData', $request->all());
        }
    }

    public function delete(int $id)
    {
        try {
            LivrosService::init()->delete($id);

            return redirect()
                ->route('livros')
                ->with('success', 'Livro removido!');
        } catch (Exception $e) {
            return redirect()
                ->route('livros')
                ->with('error', $e->getMessage());
        }
    }

    public function relatorio($tipo = 'html')
    {
        $dadosRelatorio = LivrosService::init()->relatorio();
        if ($tipo == 'html') {
            return view('relatorios.relatorio', compact('dadosRelatorio'));
        }

        if ($tipo == 'pdf') {
            $pdf = PDF::loadView('relatorios.relatoriopdf', compact('dadosRelatorio'));
            $pdf->setPaper('A4', 'landscape');

            return $pdf->stream('relatorio_livros_por_autor.pdf');
        }
    }
}
