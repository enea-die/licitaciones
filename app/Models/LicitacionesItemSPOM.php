<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicitacionesItemSPOM extends Model
{
    protected $table = 'licitaciones_item_spom';

    protected $appends = ['orden_cliente_item','estado_item'];

    public function licitacion()
    {
        return $this->hasOne('App\Models\Licitaciones', 'id','id_licitacion');
    }

    public function getOrdenClienteItemAttribute()
    {
        $idlicitacion = $this->id_licitacion;

        //buscar orden cliente
        $existsorden = OrdenCliente::where('id_licitacion',$idlicitacion)->exists();
        if($existsorden){
            $orden = OrdenCliente::where('id_licitacion',$idlicitacion)->first();
        }else{
            $orden = [];
        }

        return $orden;
    }

    public function getEstadoItemAttribute(){
        switch ($this->estado) {
            case 0:
                return "SP/OM Generado";
                break;
            case 1:
                return "Informe Adjuntado";
                break;
            case 2:
                return "Informe Aprobado";
                break;
            case 3:
                return "Informe Rechazado";
                break;
            case 4:
                return "Número HAS Ingresado";
                break;
            case 5:
                return "Solicitud Facturación Enviada";
                break;
            case 6:
                return "SP/OM Facturado";
                break;
        }
    }

}
