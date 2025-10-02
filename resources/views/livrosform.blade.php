@extends('layouts.layout')

@section('title', 'Livros')

@section('content')
    <!-- Incluindo CSS do Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Usa exatamente os mesmos estilos do Bootstrap .form-control.is-invalid */
        .is-invalid.select2-selection {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(0.375em + 0.1875rem) center !important;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
            padding-right: calc(1.5em + 0.75rem) !important;
        }
    </style>

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
        @csrf <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $livro['codigo'] ?? ''}}">

        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" maxlength="40" value="{{session('errorData')['titulo'] ?? $livro['titulo'] ?? ''}}" placeholder="Informe o título do livro" required />
            </div>

            <div class="col-md-4 mb-3">
                <label for="editora" class="form-label">Editora</label>
                <input type="text" class="form-control" id="editora" name="editora" maxlength="40" value="{{session('errorData')['editora'] ?? $livro['editora'] ?? ''}}" placeholder="Informe o nome da editora" required />
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="edicao" class="form-label">Edição</label>
                <input type="number" class="form-control" id="edicao" name="edicao" value="{{session('errorData')['edicao'] ?? $livro['edicao'] ?? ''}}" placeholder="Informe o número de edição do livro" required />
            </div>

            <div class="col-md-4 mb-3">
                <label for="anopublicacao" class="form-label">Ano de Publicação <small>(YYYY)</small></label>
                <input type="number" class="form-control" id="anopublicacao" name="anopublicacao" value="{{session('errorData')['anopublicacao'] ?? $livro['anopublicacao'] ?? ''}}" placeholder="Informe o ano de publicação do livro" required />
            </div>

            <div class="col-md-4 mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" value="{{session('errorData')['valor'] ?? $livro['valor'] ?? ''}}" placeholder="Informe o valor do livro" required />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="autor" class="form-label">Autores</label>
                <select class="form-control" id="autor" name="autor[]" multiple="multiple" required>
                    @foreach($autores as $autor)
                            <option value="{{ $autor['codigo'] }}" {{ in_array($autor['codigo'], session('errorData')['autor'] ?? array_column($livro['autores'],'codau') ?? []) ? 'selected' : '' }}>
                            {{ $autor['nome'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="assunto" class="form-label">Assunto</label>
                <select class="form-control" id="assunto" name="assunto[]" multiple="multiple" required>
                    @foreach($assuntos as $assunto)
                            <option value="{{ $assunto['codigo'] }}" {{ in_array($assunto['codigo'], session('errorData')['assunto'] ?? array_column($livro['assuntos'],'codas') ?? []) ? 'selected' : '' }}>
                            {{ $assunto['descricao'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>

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

            // gerencia o estado do campo select2
            function manageSelect2Validation() {
                $('#autor, #assunto').each(function() {
                    const $select = $(this);
                    const $select2Selection = $select.next('.select2-container').find('.select2-selection');
                    
                    $select2Selection.removeClass('is-invalid');
                    $select.removeClass('is-invalid');
                });
            }
            
            // Função para validar um campo select2 específico
            function validateSelect2(selectElement) {
                const $select = $(selectElement);
                const $select2Selection = $select.next('.select2-container').find('.select2-selection');
                const values = $select.val();
                
                if (values && values.length > 0) {
                    $select2Selection.removeClass('is-invalid');
                    $select.removeClass('is-invalid');
                    $select[0].setCustomValidity(''); // Limpa mensagem de validação HTML5
                } else {
                    if ($select.data('was-validated')) {
                        $select2Selection.addClass('is-invalid');
                        $select.addClass('is-invalid');
                        $select[0].setCustomValidity('Este campo é obrigatório. Por favor, preencha.');
                    }
                }
            }

            // Define o estado inicial dos campos select2
            manageSelect2Validation();


            $('#autor, #assunto').on('select2:select select2:unselect select2:clear', function(e) {
                validateSelect2(this);
            });

            $('form').on('submit', function(e) {
                $('#autor, #assunto').each(function() {
                    $(this).data('was-validated', true);
                    validateSelect2(this);
                });
            });
        });
    </script>
@endsection