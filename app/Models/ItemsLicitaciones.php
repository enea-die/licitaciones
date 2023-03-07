<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsLicitaciones extends Model
{
    protected $table = 'item_licitacion';

    // Relación con la tabla item
    public function item()
    {
        return $this->hasOne('App\Models\Items','id','id_item');
    }

    // Relación con la tabla licitacion
    public function licitacion()
    {
        return $this->hasOne('App\Models\Licitaciones','id','id_licitacion');
    }

}
