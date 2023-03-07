<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDocumentos extends Model
{
    use SoftDeletes;

    protected $table = 'm_tipo_documento_factura';
}
