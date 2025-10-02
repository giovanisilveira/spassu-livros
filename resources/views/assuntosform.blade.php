@extends('layouts.layout')

@section('title', 'Assuntos')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0">🏷️ Cadastrar Assunto</h1>
            <p class="text-muted mb-0">Gerencie os assuntos dos livros</p>
        </div>
        <div>
            <a href="/assuntos" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Assunto
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <form action="/assuntos" method="POST">
            @csrf <!-- Proteção contra CSRF -->

            <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $assunto['codigo'] ?? ''}}">

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição do Assunto</label>
                <input type="text" class="form-control" id="descricao" name="descricao"  maxlength="20" value="{{session('errorData')['descricao'] ?? $assunto['descricao'] ?? ''}}" placeholder="Informe um assunto para o livro" required/>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success"> <i class="fas fa-floppy-disk"></i> Salvar </button>
            </div>
        </form>
    </div>
@endsection