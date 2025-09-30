<?php

namespace Tests\Unit;

use App\DTO\AssuntoDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Tests\TestCase;

class AssuntoDTOTest extends TestCase
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
            'descricao' => 'Drama',
        ];

        $assuntoDTO = new AssuntoDTO($data);

        // Verificando se os dados foram atribuídos corretamente
        $this->assertEquals('Drama', $assuntoDTO->descricao);
    }

    public function testDeveRetornarErroCasoDescricaoNaoSejaInformado()
    {
        try{
            $data = [
                'descricao' => '',
            ];

            $assuntoDTO = new AssuntoDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'A descrição é obrigatória.');
    }

    public function testDeveRetornarErroCasoDescricaoTenhaTamanhoExcedido()
    {
        try{
            $data = [
                'descricao' => substr(bin2hex(random_bytes(25 / 2)), 0, 25),
            ];

            $assuntoDTO = new AssuntoDTO($data);
        }catch(InvalidArgumentException $e){
            $erro = $e->getMessage();
        }

        $this->assertEquals($erro, 'A descrição não pode ter mais de 20 caracteres.');
    }
}