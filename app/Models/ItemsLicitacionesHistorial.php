<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsLicitacionesHistorial extends Model
{
    protected $table = 'licitaciones_item_historial';

    // Relación con la tabla licitacion
    public function licitacion()
    {
        return $this->hasOne('App\Models\Licitaciones','id','id_licitacion');
    }

    public function usuario()
    {
        return $this->hasOne('App\Models\User','id','id_usuario');
    }

}
