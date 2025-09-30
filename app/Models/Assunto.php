<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    use HasFactory;

    protected $table = 'assunto';

    protected $primaryKey = 'codas';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['descricao'];

    protected $guarded = ['codas']; // Protege a chave primária 'codas'

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_assunto', 'assunto_codas', 'livro_codl');
    }
}
