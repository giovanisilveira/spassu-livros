<?php

namespace Tests\Unit;

use App\DTO\LivroDTO;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Mockery;
use Tests\TestCase;

class LivroDTOTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDadosValidos()
    {
        $data = [
            'titulo' => 'O Alquimista',
            'editora' => 'HarperCollins',
            'edicao' => 10,
            'anopublicacao' => '2000',
            'valor' => '99.99',
            'autor' => [1],
            'assunto' => [1],
        ];

        $livroDTO = new LivroDTO($data);

        // Verificando se os dados foram atribuídos corretamente
        $this->assertEquals('O Alquimista', $livroDTO->titulo);
        $this->assertEquals('HarperCollins', $livroDTO->editora);
        $this->assertEquals(10, $livroDTO->edicao);
        $this->assertEquals('2000', $livroDTO->anopublicacao);
        $this->assertEquals(9999, $livroDTO->valor);
        $this->assertEquals([1], $livroDTO->autor);
        $this->assertEquals([1], $livroDTO->assunto);
    }

    public function testDeveRetornarErroCasoTituloNaoSejaInformado()
    {
        try{
            $data = [
                'titulo' => '',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => '2000',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O título é obrigatório.');
    }

    public function testDeveRetornarErroCasoTituloTenhaTamanhoExcedido()
    {
        try{
            $data = [
                'titulo' => substr(bin2hex(random_bytes(45 / 2)), 0, 45),
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => '2000',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O título não pode ter mais de 40 caracteres.');
    }

    public function testDeveRetornarErroCasoAEditoraNaoSejaInformada()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => '',
                'edicao' => 10,
                'anopublicacao' => '2000',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'A editora é obrigatória.');
    }

    public function testDeveRetornarErroCasoAEditoraTenhaTamanhoExcedido()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => substr(bin2hex(random_bytes(45 / 2)), 0, 45),
                'edicao' => 10,
                'anopublicacao' => '2000',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'A editora não pode ter mais de 40 caracteres.');
    }

    public function testDeveRetornarErroCasoAEdicaoNaoSejaInformada()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'anopublicacao' => '2000',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'A edição é obrigatória.');
    }

    public function testDeveRetornarErroCasoAEdicaoNaoSejaInvalida()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => -1,
                'anopublicacao' => '2000',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'A edição deve ser maior que 0.');
    }

    public function testDeveRetornarErroCasoAEdicaoDeveSerUmNumero()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 'a',
                'anopublicacao' => '2000',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'A edição deve ser um número inteiro.');
    }

    public function testDeveRetornarErroCasoOAnoPublicacaoNaoSejaInformada()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O ano de publicação é obrigatório.');
    }

    public function testDeveRetornarErroCasoOAnoPublicacaoSejaInvalido()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => 'abc',
                'valor' => '99.99',
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O ano de publicação deve ser um ano válido (ex: ' . Carbon::now()->year . ').');
    }

    public function testDeveRetornarErroCasoOValorNaoSejaInformado()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => 2023,
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O valor é obrigatório.');
    }

    public function testDeveRetornarErroCasoOValorSejaInvalido()
    {
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => 2023,
                'valor' => 'ABC',
                'autor' => [1],
                'assunto' => [1],
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O valor deve ser um número válido.');
    }

    public function testDeveRetornarSucessoCasoOValorSejaStringNumerica()
    {
        $erro = '';
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => 2023,
                'valor' => '99',
                'autor' => [1],
                'assunto' => [1],
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, '');
        $this->assertEquals($livroDTO->valor, 9900);
    }

    public function testDeveRetornarSucessoCasoOValorTenhaSeparadorDecimalPorPonto()
    {
        $erro = '';
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => 2023,
                'valor' => 99.10,
                'autor' => [1],
                'assunto' => [1],
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, '');
        $this->assertEquals($livroDTO->valor, 9910);
    }

    public function testDeveRetornarSucessoCasoOValorSejaStringETenhaSeparadorDecimalPorVirgula()
    {
        $erro = '';
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => 2023,
                'valor' => '19,41',
                'autor' => [1],
                'assunto' => [1],
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, '');
        $this->assertEquals($livroDTO->valor, 1941);
    }

    public function testDeveRetornarSucessoCasoOValorSejaStringETenhaSeparadorDecimalEMilhar()
    {
        $erro = '';
        try{
            $data = [
                'titulo' => 'O Alquimista',
                'editora' => 'HarperCollins',
                'edicao' => 10,
                'anopublicacao' => 2023,
                'valor' => '1.000,33',
                'autor' => [1],
                'assunto' => [1],
            ];

            $livroDTO = new LivroDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, '');
        $this->assertEquals($livroDTO->valor, 100033);
    }
}
