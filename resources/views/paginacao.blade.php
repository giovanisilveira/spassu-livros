@php
    $currentPage = request()->get('page', 1);
    $prevPage = ($currentPage - 1) <= 0 ? 1 :$currentPage - 1;
    $nextPage = $currentPage + 1;
@endphp

<div class="d-flex justify-content-center">
    <a href="?page={{$prevPage}}" class="btn btn-primary">Anterior</a>
    <span class="mx-3 align-self-center">Página {{ $currentPage }}</span>
    <a href="?page={{$nextPage}}" class="btn btn-primary">Próximo</a>
</div>