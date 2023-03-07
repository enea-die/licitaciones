<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresas extends Model
{
    use SoftDeletes;

    protected $table = 'm_empresas';

    public function giro()
    {
        return $this->hasOne('App\Models\MGiros', 'id','id_giro');
    }

}
