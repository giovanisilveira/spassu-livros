<?php

namespace App\Http\Controllers;

use App\DTO\AssuntoDTO;
use App\Services\AssuntosService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AssuntosController extends Controller
{
    public function index(Request $request)
    {
        try{
            $search = $request->input('search') ?? '';

            $assuntos = AssuntosService::init()->list(
                $search,
                $request->input('page') ?? 1
            ) ?? [];

            return view('assuntos', [
                'assuntos' => $assuntos,
                'search' => $search,
            ]);
        }catch(Exception $e){
            return redirect()
                ->route('assuntos')
                ->with('error', $e->getMessage());
        }
    }

    public function formulario($id = null, Request $request)
    {
        try{
            $assunto = AssuntosService::init()->getById((int) $id);

            return view('assuntosform', ['assunto' => $assunto]);
        } catch (Exception $e) {
            return redirect()
                ->route('assuntos')
                ->with('error', $e->getMessage())
                ->with('errorData', $request->all());
        }
    }

    public function salvar(Request $request)
    {
        try {
            $data = $request->all();

            $assuntoDTO = (new AssuntoDTO($data));
            AssuntosService::init()->save($assuntoDTO);

            return redirect()
                ->route('assuntos')
                ->with('success', 'Assunto salvo com sucesso!');
        } catch (Exception $e) {
            return redirect()
                ->route('assuntosform')
                ->with('error', $e->getMessage())
                ->with('errorData', $data);
        }
    }

    public function delete(int $id)
    {
        try {
            AssuntosService::init()->delete($id);

            return redirect()
                ->route('assuntos')
                ->with('success', 'Assunto removido!');
        } catch (Exception $e) {
            return redirect()
                ->route('assuntos')
                ->with('error', $e->getMessage());
        }
    }
}
