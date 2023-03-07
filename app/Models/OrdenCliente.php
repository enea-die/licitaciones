<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCliente extends Model
{
    protected $table = 'orden_cliente';

    // Relación con la tabla licitacion
    public function licitacion()
    {
        return $this->hasOne('App\Models\Licitaciones','id','id_licitacion');
    }

}
