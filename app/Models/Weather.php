<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weather';
    protected $fillable = ['city', 'data', 'updated_at']; //agregue updated_at a fillable para poder actualizar manualmente en la base de datos
                                                          // en caso de no haber cambios relevantes y forzar el guardado en la base de datos para no hacer muchas peticiones a la url
    public $timestamps = true;
}
