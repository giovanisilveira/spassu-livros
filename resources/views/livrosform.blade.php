@extends('layouts.layout')

@section('title', 'Livros')

@section('content')
    <!-- Incluindo CSS do Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Ajustes para adaptar o select2 ao layout do formulário -->
    <style>
        .is-invalid.select2-selection {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(0.375em + 0.1875rem) center !important;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
            padding-right: calc(1.5em + 0.75rem) !important;
        }

        .input-group .select2-container {
            flex: 1 1 auto;
            width: auto !important;
        }

        .input-group .select2-container .select2-selection {
            border-left: 0;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            height: calc(2.25rem + 2px);
        }

        .input-group .select2-container .select2-selection--multiple {
            min-height: calc(2.25rem + 2px);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: -0.625rem 0.75rem;
        }
    </style>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0">📚 Cadastrar Livro</h1>
            <p class="text-muted mb-0">Gerencie o catálogo de livros</p>
        </div>
        <div>
            <a href="/livros" class="btn btn-primary">
                <i class="fas fa-arrow-left "></i> Voltar
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"> Informações do Livro </h5>
        </div>
        <div class="card-body">
            <form action="/livros" method="POST" class="row g-3">
            @csrf <!-- Proteção contra CSRF -->
        
            <input type="hidden" name="codigo" value="{{session('errorData')['codigo'] ?? $livro['codigo'] ?? ''}}">


                <div class="col-md-8">
                    <label for="titulo" class="form-label">Título do Livro</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-heading"></i>
                        </span>
                        <input type="text" 
                                id="titulo"
                                name="titulo" 
                                class="form-control" 
                                placeholder="Informe o título do livro" 
                                maxlength="40" 
                                value="{{session('errorData')['titulo'] ?? $livro['titulo'] ?? ''}}"
                                autocomplete="off"
                                required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="editora" class="form-label">Editora</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-building"></i>
                        </span>
                        <input type="text" 
                                id="editora"
                                name="editora" 
                                class="form-control" 
                                maxlength="40" 
                                value="{{session('errorData')['editora'] ?? $livro['editora'] ?? ''}}"
                                placeholder="Informe o nome da editora"
                                autocomplete="off"
                                required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="edicao" class="form-label">Edição</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-sort-numeric-up"></i>
                        </span>
                        <input type="number" 
                                id="edicao"
                                name="edicao" 
                                class="form-control" 
                                maxlength="40" 
                                value="{{session('errorData')['edicao'] ?? $livro['edicao'] ?? ''}}" 
                                placeholder="Informe o número de edição do livro"
                                autocomplete="off"
                                required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="anopublicacao" class="form-label">Ano de Publicação <small>(YYYY)</small></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <input type="number" 
                                id="anopublicacao"
                                name="anopublicacao" 
                                class="form-control" 
                                maxlength="4" 
                                value="{{session('errorData')['anopublicacao'] ?? $livro['anopublicacao'] ?? ''}}" 
                                placeholder="Informe o ano de publicação do livro"
                                autocomplete="off"
                                required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="valor" class="form-label">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <input type="text" 
                                id="valor"
                                name="valor" 
                                class="form-control" 
                                value="{{session('errorData')['valor'] ?? $livro['valor'] ?? ''}}" 
                                placeholder="Informe o valor do livro"
                                autocomplete="off"
                                required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label for="autor" class="form-label">Autores</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user-pen"></i>
                        </span>
                        <select class="form-control select2 col-md-" id="autor" name="autor[]" multiple="multiple" required>
                            @foreach($autores as $autor)
                                <option value="{{ $autor['codigo'] }}" {{ in_array($autor['codigo'], session('errorData')['autor'] ?? array_column($livro['autores'] ?? [],'codau') ?? []) ? 'selected' : '' }}>
                                    {{ $autor['nome'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="assunto" class="form-label">Assunto</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-tags"></i>
                        </span>
                        <select class="form-control select2" id="assunto" name="assunto[]" multiple="multiple" required>
                            <option value="">Selecione um assunto</option>
                            @foreach($assuntos as $assunto)
                                <option value="{{ $assunto['codigo'] }}" {{ in_array($assunto['codigo'], session('errorData')['assunto'] ?? array_column($livro['assuntos'],'codas') ?? []) ? 'selected' : '' }}>
                                    {{ $assunto['descricao'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-success"> <i class="fas fa-floppy-disk"></i> Salvar </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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