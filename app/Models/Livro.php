<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livro';

    protected $primaryKey = 'codl';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'anopublicacao',
        'valor'
    ];

    protected $guarded = ['codl'];

    public $timestamps = false;

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'livro_codl', 'autor_codau');
    }

    public function assuntos()
    {
        return $this->belongsToMany(Assunto::class, 'livro_assunto', 'livro_codl', 'assunto_codas');
    }
}
