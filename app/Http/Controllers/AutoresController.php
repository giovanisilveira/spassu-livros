<?php

namespace App\Http\Controllers;

use App\DTO\AutorDTO;
use App\DTO\LivroDTO;
use App\Services\AutoresService;
use App\Services\LivrosService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AutoresController extends Controller
{
    public function index(Request $request)
    {
        try{
            $search = $request->input('search') ?? '';

            $autores = AutoresService::init()->list(
                $search,
                $request->input('page') ?? 1
            ) ?? [];

            return view('autores', [
                'autores' => $autores,
                'search' => $search
            ]);
        }catch(Exception $e){
            return redirect()
                ->route('autores')
                ->with('error', $e->getMessage());
        }
    }

    public function formulario($id = null, Request $request)
    {
        try{
            $autor = AutoresService::init()->getById((int) $id);

            return view('autoresform', ['autor' => $autor]);
        }catch(Exception $e){
            return redirect()
                ->route('autores')
                ->with('error', $e->getMessage())
                ->with('errorData', $request->all());
        }
    }

    public function salvar(Request $request)
    {
        try {
            $autorDTO = (new AutorDTO($request->all()));

            AutoresService::init()->save($autorDTO);

            return redirect()
                ->route('autores')
                ->with('success', 'Autor salvo com sucesso!');
        } catch (Exception $e) {
            return redirect()
                ->route('autoresform')
                ->with('error', $e->getMessage())
                ->with('errorData', $request->all());
        }
    }

    public function delete(int $id)
    {
        try {
            AutoresService::init()->delete($id);

            return redirect()
                ->route('autores')
                ->with('success', 'Autor removido!');
        } catch (Exception $e) {
            return redirect()
                ->route('autores')
                ->with('error', $e->getMessage());
        }
    }
}
