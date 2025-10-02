<?php

namespace App\DTO;

class RelatorioOutputDTO extends DTO
{
    public $result = [];

    public function __construct(array $dados)
    {
        foreach ($dados as $livros) {
            $livrosAutor = explode("|", $livros->livros);
            $livrosFormatados = [];
            foreach ($livrosAutor as $livro) {
                $dadosLivros = explode(",", $livro);
                $livrosFormatados[] = [
                    'codigo' => $dadosLivros[0],
                    'titulo' => $dadosLivros[1],
                    'editora' => $dadosLivros[2],
                    'edicao' => $dadosLivros[3],
                    'ano_publicacao' => $dadosLivros[4],
                    'valor' => $this->formatarValor($dadosLivros[5]),
                    'assuntos' => $this->formatarAssuntos($dadosLivros[6] ?? 'Sem assunto'),
                    'assuntos_texto' => $this->formatarAssuntosTexto($dadosLivros[6] ?? 'Sem assunto')
                ];
            }
            $this->result[$livros->autor_nome] = $livrosFormatados;
        }
    }

    public function toArray() : array {
        return $this->result;
    }

    /**
     * Formata os assuntos como array
    */
    private function formatarAssuntos($assuntosString): array
    {
        if (empty($assuntosString) || $assuntosString === 'Sem assunto') {
            return ['Sem assunto'];
        }
        
        return explode(';', $assuntosString);
    }

    /**
     * Formata os assuntos como texto legível
     */
    private function formatarAssuntosTexto($assuntosString): string
    {
        if (empty($assuntosString) || $assuntosString === 'Sem assunto') {
            return 'Sem assunto';
        }
        
        $assuntos = explode(';', $assuntosString);
        
        if (count($assuntos) === 1) {
            return $assuntos[0];
        }
        
        if (count($assuntos) === 2) {
            return implode(' e ', $assuntos);
        }
        
        $ultimoAssunto = array_pop($assuntos);
        return implode(', ', $assuntos) . ' e ' . $ultimoAssunto;
    }
}