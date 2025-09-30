@extends('layouts.layout')

@section('title', 'Livros')

@section('content')
    <!-- Incluindo CSS do Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="btn btn-primary btn-md" href="/livros" role="button">Voltar</a>
        </li>
    </ul>

    <hr class="my-4">

    <div class="container mt-5">
        <h2>Cadastrar Livro</h2>
        <form action="/livros" method="POST">
            @csrf <!-- Proteção contra CSRF -->

            <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $livro['codigo'] ?? ''}}">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="{{session('errorData')['titulo'] ?? $livro['titulo'] ?? ''}}" required />
            </div>

            <div class="mb-3">
                <label for="editora" class="form-label">Editora</label>
                <input type="text" class="form-control" id="editora" name="editora" value="{{session('errorData')['editora'] ?? $livro['editora'] ?? ''}}" required />
            </div>

            <div class="mb-3">
                <label for="edicao" class="form-label">Edição</label>
                <input type="number" class="form-control" id="edicao" name="edicao" value="{{session('errorData')['edicao'] ?? $livro['edicao'] ?? ''}}" required />
            </div>

            <div class="mb-3">
                <label for="anopublicacao" class="form-label">Ano de Publicação <small>(ex: YYYY)</small></label>
                <input type="number" class="form-control" id="anopublicacao" name="anopublicacao" value="{{session('errorData')['anopublicacao'] ?? $livro['anopublicacao'] ?? ''}}" required />
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" value="{{session('errorData')['valor'] ?? $livro['valor'] ?? ''}}" required />
            </div>

            <div class="mb-3">
                <label for="autor" class="form-label">Autores</label>
                <select class="form-control" id="autor" name="autor[]" multiple="multiple" required>
                    @foreach($autores as $autor)
                            <option value="{{ $autor['codigo'] }}" {{ in_array($autor['codigo'], session('errorData')['autor'] ?? array_column($livro['autores'],'codau') ?? []) ? 'selected' : '' }}>
                            {{ $autor['nome'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
            <label for="assunto" class="form-label">Assunto</label>
                <select class="form-control" id="assunto" name="assunto[]" multiple="multiple" required>
                    @foreach($assuntos as $assunto)
                            <option value="{{ $assunto['codigo'] }}" {{ in_array($assunto['codigo'], session('errorData')['assunto'] ?? array_column($livro['assuntos'],'codas') ?? []) ? 'selected' : '' }}>
                            {{ $assunto['descricao'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7/dist/inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            Inputmask("currency", {
                prefix: "R$ ",
                groupSeparator: ".",
                radixPoint: ",",
                autoGroup: true,
                rightAlign: false
            }).mask("#valor");

            $('#autor').select2({
                placeholder: "Selecione os autores",
                allowClear: true
            });

            $('#assunto').select2({
                placeholder: "Selecione os assuntos",
                allowClear: true
            });
        });
    </script>
@endsection