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
                <i class="fas fa-arrow-left "></i> Voltar
            </a>
        </div>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"> Informações do Assunto </h5>
        </div>
        <div class="card-body">
            <form action="/assuntos" method="POST" class="row g-3">
                @csrf <!-- Proteção contra CSRF -->

                <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $assunto['codigo'] ?? ''}}">

                <div class="col-md-8">
                    <label for="descricao" class="form-label">Descrição do Assunto</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-tag"></i>
                        </span>
                        <input type="text" 
                                id="descricao"
                                name="descricao" 
                                class="form-control" 
                                placeholder="Informe um assunto para o livro" 
                                maxlength="20" 
                                value="{{session('errorData')['descricao'] ?? $assunto['descricao'] ?? ''}}"
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