@extends('layouts.layout')

@section('title', 'Autores')

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0">✍️ Gerenciar Autores</h1>
            <p class="text-muted mb-0">Gerencie os autores dos livros</p>
        </div>
        <div>
            <a href="/autores/formulario" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Autor
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">🔍 Buscar Autores</h5>
        </div>
        <div class="card-body">
            <form action="/autores" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">Buscar por nome</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                                id="search"
                                name="search" 
                                class="form-control" 
                                placeholder="Digite o nome do autor..." 
                                value="{{$search}}"
                                autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        @if(!empty($search))
                            <a href="/autores" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Limpar
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th style="width: 80px;">Código</th>
                    <th>Nome</th>
                    <th style="width: 140px;" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($autores as $autor)
                <tr>
                    <td>
                        <code class="text-muted">#{{$autor['codigo']}}</code>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $autor['nome'] }}</div>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="/autores/formulario/{{$autor['codigo']}}" 
                                class="btn btn-outline-primary" 
                                title="Editar autor">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('autordelete', $autor['codigo']) }}" method="POST" style="display:inline;" id="delete-form-{{ $autor['codigo'] }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $autor['codigo'] }}, '{{ addslashes($autor['nome']) }}')"
                                        title="Excluir autor">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    @include('paginacao')

    <script>
        function confirmDelete(id, nome) {
            if (confirm("Tem certeza que deseja excluir este autor: " + nome + "?")) {
                return document.getElementById('delete-form-' + id).submit();
            }

            return false;
        }
    </script>
@endsection