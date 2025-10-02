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
                <i class="fas fa-arrow-left "></i> Voltar
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"> Informações do Assunto </h5>
        </div>
        <div class="card-body">
            <form action="/autores" method="POST" class="row g-3">
                @csrf <!-- Proteção contra CSRF -->

                <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $autor['codigo'] ?? ''}}">

                <div class="col-md-8">
                    <label for="nome" class="form-label">Nome do Autor</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user-pen"></i>
                        </span>
                        <input type="text" 
                                id="nome"
                                name="nome" 
                                class="form-control" 
                                placeholder="Informe o nome do autor" 
                                maxlength="40" 
                                value="{{session('errorData')['nome'] ?? $autor['nome'] ?? ''}}"
                                autocomplete="off"
                                required>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-success"> <i class="fas fa-floppy-disk"></i> Salvar </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection