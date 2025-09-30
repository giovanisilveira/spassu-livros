<?php

namespace Tests\Unit;

use App\Models\Livro;
use App\Services\LivrosService;
use Illuminate\Support\Carbon;
use Mockery;
use Tests\TestCase;

class LivroServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDadosValidos() {
        $codigoLivro = 99;
        $livroMock = Mockery::mock(Livro::class);

        $livroMock->shouldReceive('find')
            ->with($codigoLivro) // Id que queremos simular
            ->once()
            ->andReturn((object)[
                'codl' => $codigoLivro,
                'titulo' => 'Título do Livro',
                'editora' => 'Editora XYZ',
                'edicao' => 1,
                'anopublicacao' => '2020',
                'valor' => 50.00
            ]);

        $livroService = new LivrosService($livroMock);
        $livro = $livroService->getById($codigoLivro);

        $this->assertEquals($codigoLivro, $livro['codigo']);
    }
}
