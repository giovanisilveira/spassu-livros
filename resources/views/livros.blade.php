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

    <h1 class="display-7">Livros</h1>
    <hr class="my-4">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="btn btn-success btn-md" href="/livros/formulario" role="button">Cadastro</a>
        </li>
    </ul>

    <div class="container mt-5">
        <h2>Busca</h2>
        <form action="/livros" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Digite sua busca" value="{{$search}}">

            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>

    <div class="container mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="100px">Código</th>
                    <th>Nome</th>
                    <th width="200px">Assunto</th>
                    <th class="text-end">Valor</th>
                    <th width="180px">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($livros as $livro)
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
                            <a href="/livros/formulario/{{$livro['codigo']}}" class="btn btn-primary btn-sm">Alterar</a>
                            <form action="{{ route('livrodelete', $livro['codigo']) }}" method="POST" style="display:inline;" id="delete-form-{{ $livro['codigo'] }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $livro['codigo'] }})">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('paginacao')

    <script>
        function confirmDelete(id) {
            if (confirm("Tem certeza que deseja excluir este livro?")) {
                return document.getElementById('delete-form-' + id).submit();
            }

            return false;
        }
    </script>
@endsection