@extends('layouts.layout')

@section('title', 'Assuntos')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="btn btn-primary btn-md" href="/assuntos" role="button">Voltar</a>
        </li>
    </ul>

    <hr class="my-4">

    <div class="container mt-5">
        <h2>Cadastrar Assunto</h2>
        <form action="/assuntos" method="POST">
            @csrf <!-- Proteção contra CSRF -->

            <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $assunto['codigo'] ?? ''}}">

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição do Assunto</label>
                <input type="text" class="form-control" id="descricao" name="descricao" value="{{session('errorData')['descricao'] ?? $assunto['descricao'] ?? ''}}" required/>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection