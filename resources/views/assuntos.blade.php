@extends('layouts.layout')

@section('title', 'Assuntos')

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
            <h1 class="h2 mb-0">🏷️ Gerenciar Assuntos</h1>
            <p class="text-muted mb-0">Gerencie os assuntos dos livros</p>
        </div>
        <div>
            <a href="/assuntos/formulario" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Assunto
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">🔍 Buscar Assuntos</h5>
        </div>
        <div class="card-body">
            <form action="/assuntos" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">Buscar por assunto</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                                id="search"
                                name="search" 
                                class="form-control" 
                                placeholder="Digite o assunto..." 
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
                            <a href="/assuntos" class="btn btn-outline-secondary">
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
                    <th>Assunto</th>
                    <th style="width: 140px;" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assuntos as $assunto)
                <tr>
                    <td>
                        <code class="text-muted">#{{$assunto['codigo']}}</code>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $assunto['descricao'] }}</div>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="/assuntos/formulario/{{$assunto['codigo']}}" 
                                class="btn btn-outline-primary" 
                                title="Editar assunto">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('assuntodelete', $assunto['codigo']) }}" method="POST" style="display:inline;" id="delete-form-{{ $assunto['codigo'] }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $assunto['codigo'] }}, '{{ addslashes($assunto['descricao']) }}')"
                                        title="Excluir assunto">
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
        function confirmDelete(id, descricao) {
            if (confirm("Tem certeza que deseja excluir este asunto: " + descricao + "?")) {
                return document.getElementById('delete-form-' + id).submit();
            }

            return false;
        }
    </script>
@endsection