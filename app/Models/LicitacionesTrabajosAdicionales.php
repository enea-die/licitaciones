<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicitacionesTrabajosAdicionales extends Model
{
    protected $table = 'licitaciones_trabajos_adicionales';

    public function itemsspom()
    {
        return $this->hasMany('App\Models\LicitacionesItemSPOMTrabajosAdicionales','id_trabajo_adicional', 'id');
    }
}
