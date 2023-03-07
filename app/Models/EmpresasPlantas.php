<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresasPlantas extends Model
{
    protected $table = 'empresas_plantas';

    public function areas()
    {
        return $this->hasMany('App\Models\EmpresasPlantasAreas','id_planta', 'id');
    }
}
