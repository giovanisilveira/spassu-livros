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

    <h1 class="display-7">Autores</h1>
    <hr class="my-4">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="btn btn-success btn-md" href="/autores/formulario" role="button">Cadastro</a>
        </li>
    </ul>

    <div class="container mt-5">
        <h2>Busca</h2>
        <form action="/autores" method="GET" class="d-flex">
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
                    <th width="180px">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($autores as $autor)
                    <tr>
                        <td>{{$autor['codigo']}}</td>
                        <td>{{$autor['nome']}}</td>
                        <td>
                            <a href="/autores/formulario/{{$autor['codigo']}}" class="btn btn-primary btn-sm">Alterar</a>
                            <form action="{{ route('autordelete', $autor['codigo']) }}" method="POST" style="display:inline;" id="delete-form-{{ $autor['codigo'] }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $autor['codigo'] }})">Excluir</button>
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
            if (confirm("Tem certeza que deseja excluir este autor?")) {
                return document.getElementById('delete-form-' + id).submit();
            }

            return false;
        }
    </script>
@endsection