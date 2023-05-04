<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Archivo;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_categoria',
        'id_usuario',
        'titulo_evento',
        'descripcion_evento',
        'estado_evento'
    ];

    //Relación uno a muchos inversa con usuario

    public function user(){
        $this->belongsTo(User::class);
    }

    //Relación uno a muchos inversa con categoria

    public function categoria(){
        $this->belongsTo(Categoria::class);
    }

     //relacion polimorfica con archivo

    public function archivos(){
        return $this->morphMany(Archivo::class, 'imageable');
    }

}
