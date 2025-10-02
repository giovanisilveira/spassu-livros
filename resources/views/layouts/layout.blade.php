<!-- resources/views/layouts/layout.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Página Inicial')</title>

    <!-- Importando o Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Importando o Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Livros App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/assuntos">Assuntos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/autores">Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/livros">Livros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/livros/relatorio">Relatório</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo da página -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script genérico para validação dos campos required dos formulários-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const camposObrigatorios = document.querySelectorAll('input[required], textarea[required], select[required]');
            camposObrigatorios.forEach(campo => {
                campo.addEventListener('invalid', function(event) {
                    if (campo.type == 'number') {
                        this.setCustomValidity('Por favor, digite um número válido para este campo.');
                    } else {
                        this.setCustomValidity('Este campo é obrigatório. Por favor, preencha com um valor válido.');
                    }

                    this.classList.add('is-invalid');

                    if (campo.tagName.toUpperCase() === 'SELECT') {
                        campo.nextElementSibling.querySelector('.select2-selection').classList.add('is-invalid')
                    }
                });

                if (campo.tagName.toUpperCase() === 'SELECT') {
                    campo.addEventListener('change', function(event) {
                        campo.nextElementSibling.querySelector('.select2-selection').classList.remove('is-invalid')
                    });
                } else {
                    campo.addEventListener('input', function(event) {
                        this.setCustomValidity('');
                        this.classList.remove('is-invalid');
                    });
                }
            });
        });
    </script>
</body>
</html>