<?php

namespace App\DTO;

use InvalidArgumentException;

abstract class DTO
{
    protected function normalizeValor($valor): int
    {
        if (is_string($valor)) {
            $valor = preg_replace('/[^0-9.,]/', '', $valor); //Remoe qualquer caractere que não seja números, pontos ou vírgula
            if (strpos($valor, ',') !== false) {
                $valor = preg_replace(['/\./', '/,/',], ['', '.'], $valor);
            } else {
                $valor = preg_replace('/,/', '.', $valor);
            }
        }

        if (!is_numeric($valor)) {
            throw new InvalidArgumentException("O valor deve ser um número válido.");
        }

        return (int) ($valor * 100);
    }

    protected function formatarValor(int $valor) : string
    {
        return number_format($valor/100, 2, ',', '.');
    }

    public function toArray(): array
    {
        return [];
    }
}
