@extends('layouts.layout')

@section('title', 'Relatório')

@section('content')
    <a href="/livros/relatorio/pdf" target="_blank" class="btn btn-outline-primary btn-sm">
        Exibir Relatório PDF
    </a>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Relatório de Livros por Autor</h1>

        <!-- Tabela -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Autor</th>
                    <th>Título do Livro</th>
                    <th>Editora</th>
                    <th>Edição</th>
                    <th>Ano de Publicação</th>
                    <th class="text-end">Preço</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dadosRelatorio as $autorNome => $livros)
                    <tr>
                        <td colspan="6">
                            {{ $autorNome }}
                        </td>
                    </tr>
                    @foreach ($livros as $livro)
                        <tr>
                            <td></td>
                            <td>{{$livro['titulo']}}</td>
                            <td>{{$livro['editora']}}</td>
                            <td>{{$livro['edicao']}}</td>
                            <td>{{$livro['ano_publicacao']}}</td>
                            <td style="text-align: right;">{{$livro['valor']}}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection