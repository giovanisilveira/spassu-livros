@extends('layouts.layout')

@section('title', 'Autores')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0">✍️ Cadastrar Autor</h1>
            <p class="text-muted mb-0">Gerencie os autores dos livros</p>
        </div>
        <div>
            <a href="/autores" class="btn btn-primary">
                <i class="fas fa-plus"></i> Voltar
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <form action="/autores" method="POST">
            @csrf <!-- Proteção contra CSRF -->

            <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $autor['codigo'] ?? ''}}">

            <div class="mb-3">
                <label for="descricao" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome"  maxlength="40" value="{{session('errorData')['nome'] ?? $autor['nome'] ?? ''}}" placeholder="Informe o nome do autor" required/>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success"> <i class="fas fa-floppy-disk"></i> Salvar </button>
            </div>
        </form>
    </div>
@endsection