<?php

namespace Tests\Unit;

use App\DTO\AutorDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Tests\TestCase;

class AutorDTOTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDadosValidos()
    {
        // Dados válidos para o DTO
        $data = [
            'nome' => 'Paulo Coelho',
        ];

        $autorDTO = new AutorDTO($data);

        // Verificando se os dados foram atribuídos corretamente
        $this->assertEquals('Paulo Coelho', $autorDTO->nome);
    }

    public function testDeveRetornarErroCasoNomeNaoSejaInformado()
    {
        try{
            $data = [
                'nome' => '',
            ];

            $autorDTO = new AutorDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O nome é obrigatório.');
    }

    public function testDeveRetornarErroCasoNomeTenhaTamanhoExcedido()
    {
        try{
            $data = [
                'nome' => substr(bin2hex(random_bytes(45 / 2)), 0, 45),
            ];

            $autorDTO = new AutorDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'O nome não pode ter mais de 40 caracteres.');
    }
}