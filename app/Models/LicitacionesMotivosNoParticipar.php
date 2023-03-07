<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicitacionesMotivosNoParticipar extends Model
{
    protected $table = 'licitaciones_motivos_no_participar';

    public function motivo()
    {
        return $this->hasOne('App\Models\MMotivosNoParticipar', 'id','id_motivo');
    }
}
