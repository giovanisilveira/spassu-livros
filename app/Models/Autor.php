<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autor';

    protected $primaryKey = 'codau';

    public $incrementing = true;

    public $timestamps = false;

    protected $keyType = 'int';

    protected $fillable = ['nome'];

    protected $guarded = ['codau'];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_autor', 'autor_codau', 'livro_codl');
    }
}
