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
                    @foreach($livros as $livro)
                        <tr>
                            <!-- Exibindo o nome do autor apenas na primeira linha de cada autor -->
                            @if ($loop->first)
                                <td rowspan="{{ count($livros) }}" class="align-middle">{{ $autorNome }}</td>
                            @endif
                            <td>{{ $livro->livro_titulo }}</td>
                            <td>{{ $livro->livro_editora }}</td>
                            <td>{{ $livro->livro_edicao }}</td>
                            <td>{{ $livro->livro_anopublicacao }}</td>
                            <td class="text-end">R$ {{ number_format($livro->livro_valor / 100, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{--
    <div class="container mt-5">
        <h1 class="mb-4">Livros por Autor</h1>

        @foreach($dadosRelatorio as $autorNome => $livros)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">{{ $autorNome }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($livros as $livro)
                            <li class="list-group-item">
                                <strong>{{ $livro->livro_titulo }}</strong><br>
                                <small><i>{{ $livro->livro_editora }} | {{ $livro->livro_anopublicacao }} | R$ {{ number_format($livro->livro_valor / 100, 2, ',', '.') }}</i></small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    --}}
@endsection