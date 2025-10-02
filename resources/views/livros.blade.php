@extends('layouts.layout')

@section('title', 'Livros')

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
            <h1 class="h2 mb-0">📚 Gerenciar Livros</h1>
            <p class="text-muted mb-0">Gerencie o catálogo de livros</p>
        </div>
        <div>
            <a href="/livros/formulario" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Livro
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">🔍 Buscar Livros</h5>
        </div>
        <div class="card-body">
            <form action="/livros" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">Buscar por título</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                                id="search"
                                name="search" 
                                class="form-control" 
                                placeholder="Digite o título do livro..." 
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
                            <a href="/livros" class="btn btn-outline-secondary">
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
                    <th>Título</th>
                    <th style="width: 150px;">Editora</th>
                    <th style="width: 80px;" class="text-center">Edição</th>
                    <th style="width: 100px;" class="text-center">Ano</th>
                    <th style="width: 200px;">Assuntos</th>
                    <th style="width: 120px;" class="text-end">Valor</th>
                    <th style="width: 140px;" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($livros as $livro)
                <tr>
                    <td>
                        <code class="text-muted">#{{$livro['codigo']}}</code>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $livro['titulo'] }}</div>
                        @if(!empty($livro['autores']))
                            <small class="text-muted">
                                por {{ implode(', ', array_column($livro['autores'], 'nome')) }}
                            </small>
                        @endif
                    </td>
                    <td>{{ $livro['editora'] ?? '-' }}</td>
                    <td class="text-center">{{ $livro['edicao'] ?? '-' }}</td>
                    <td class="text-center">{{ $livro['anopublicacao'] ?? '-' }}</td>
                    <td>
                        @forelse(array_column($livro['assuntos'],'descricao') as $assunto)
                            <span class="badge bg-secondary me-1 mb-1">{{ $assunto }}</span>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </td>
                    <td class="text-end">
                        <span class="fw-bold text-success">R$ {{ $livro['valor'] }}</span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="/livros/formulario/{{$livro['codigo']}}" 
                                class="btn btn-outline-primary" 
                                title="Editar livro">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('livrodelete', $livro['codigo']) }}" method="POST" style="display:inline;" id="delete-form-{{ $livro['codigo'] }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $livro['codigo'] }}, '{{ addslashes($livro['titulo']) }}')"
                                        title="Excluir livro">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                {{--
                    <tr>
                        <td>{{$livro['codigo']}}</td>
                        <td>{{ $livro['titulo'] }}</td>
                        <td>
                            @foreach ( array_column($livro['assuntos'],'descricao') as $assunto )
                                <span class="badge bg-primary text-dark">{{ $assunto }}</span>
                            @endforeach
                        </td>
                        <td class="text-end">{{ $livro['valor'] }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="/livros/formulario/{{$livro['codigo']}}" 
                                    class="btn btn-outline-primary" 
                                    title="Editar livro">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('livrodelete', $livro['codigo']) }}" method="POST" style="display:inline;" id="delete-form-{{ $livro['codigo'] }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $livro['codigo'] }}, '{{ addslashes($livro['titulo']) }}')"
                                            title="Excluir livro">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    --}}
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    @include('paginacao')

    <script>
        function confirmDelete(id, titulo) {
            if (confirm("Tem certeza que deseja excluir este livro: " + titulo + "?")) {
                return document.getElementById('delete-form-' + id).submit();
            }

            return false;
        }
    </script>
@endsection