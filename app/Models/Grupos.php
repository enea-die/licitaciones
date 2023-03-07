<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupos extends Model
{
    use SoftDeletes;

    protected $table = 'm_grupos';

    // Relación con la tabla jefeoperaciones
    public function jefeoperaciones()
    {
        return $this->hasOne('App\Models\User','id','id_jefe_operaciones');
    }

    // Relación con la tabla responsable
    public function responsable()
    {
        return $this->hasOne('App\Models\User','id','id_responsable');
    }

    // Relación con la tabla planificador
    public function planificador()
    {
        return $this->hasOne('App\Models\User','id','id_planificacion');
    }

    // Relación con la tabla contabilidad
    public function contabilidad()
    {
        return $this->hasOne('App\Models\User','id','id_contabilidad');
    }

}
