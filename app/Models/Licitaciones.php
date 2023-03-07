<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licitaciones extends Model
{
    use SoftDeletes;

    protected $table = 'licitaciones';

    protected $appends = ['item_personas','item_materiales','item_servicios'];

    public function tipo()
    {
        return $this->hasOne('App\Models\TipoLicitaciones', 'id','id_tipo_licitacion');
    }

    public function tipocentrocosto()
    {
        return $this->hasOne('App\Models\MTipoCentroCosto', 'id','id_tipo_centrocosto');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Empresas', 'id','id_empresa');
    }

    public function planta()
    {
        return $this->hasOne('App\Models\EmpresasPlantas', 'id','id_planta');
    }

    public function area()
    {
        return $this->hasOne('App\Models\EmpresasPlantasAreas', 'id','id_area');
    }

    public function pgp()
    {
        return $this->hasOne('App\Models\EmpresasPGP', 'id','id_pgp');
    }

    public function etapa()
    {
        return $this->hasOne('App\Models\Etapas', 'id','id_etapa');
    }

    public function grupo()
    {
        return $this->hasOne('App\Models\Grupos', 'id','id_grupo');
    }

    public function familia()
    {
        return $this->hasOne('App\Models\MFamilias', 'id','id_familia');
    }

    public function jefeoperaciones()
    {
        return $this->hasOne('App\Models\User', 'id','id_jefe_operaciones');
    }

    public function responsable()
    {
        return $this->hasOne('App\Models\User', 'id','id_responsable');
    }

    public function planificador()
    {
        return $this->hasOne('App\Models\User', 'id','id_planificacion');
    }

    public function contabilidad()
    {
        return $this->hasOne('App\Models\User', 'id','id_contabilidad');
    }

    public function getItemPersonasAttribute()
    {
        $idlicitacion = $this->id;

        $existsitempersona = ItemsLicitaciones::where('id_licitacion',$idlicitacion)->where('id_item',1)->exists();

        if($existsitempersona){
            return ItemsLicitaciones::where('id_licitacion',$idlicitacion)->where('id_item',1)->first();
        }else{
            return null;
        }
    }

    public function getItemMaterialesAttribute()
    {
        $idlicitacion = $this->id;

        $existsitemateriales = ItemsLicitaciones::where('id_licitacion',$idlicitacion)->where('id_item',2)->exists();

        if($existsitemateriales){
            return ItemsLicitaciones::where('id_licitacion',$idlicitacion)->where('id_item',2)->first();
        }else{
            return null;
        }
    }

    public function getItemServiciosAttribute()
    {
        $idlicitacion = $this->id;

        $existsitemservicios = ItemsLicitaciones::where('id_licitacion',$idlicitacion)->where('id_item',3)->exists();

        if($existsitemservicios){
            return ItemsLicitaciones::where('id_licitacion',$idlicitacion)->where('id_item',3)->first();
        }else{
            return null;
        }
    }

    public function next(){
        switch ($this->id_etapa) {
            case 0:
                return "N/D";
                break;
            case 1:
                return "Solicitar participación licitación";
                break;
            case 2:
                return "Responder solicitud participación";
                break;
            case 3:
                return "Responder solicitud no participación";
                break;
            case 4:
                return "Asignar responsable";
                break;
            case 5:
                return "Licitación finalizada";
                break;
            case 6:
                return "Gestionar visita";
                break;
            case 7:
                return "Generar cotizaciones";
                break;
            case 8:
                return "Responder solicitud dar de baja";
                break;
            case 9:
                return "Licitación finalizada";
                break;
            case 10:
                return "Generar cotizaciones";
                break;
            case 11:
                return "Enviar solicitud revisión de cotizaciones";
                break;
            case 12:
                return "Responder solicitud de revisión de cotizaciones";
                break;
            case 13:
                return "Re-generar cotizaciones por rechazo";
                break;
            case 14:
                if($this->id_tipo_licitacion == 4){
                    if($this->pgp_aprobacioncot_subgerenteoperaciones == 0){
                        return "Aprobar cotizaciones Sub-Gerente Operaciones";
                    }else{
                        if($this->pgp_aprobacioncot_subgerentegeneral == 0){
                            return "Aprobar cotizaciones Sub-Gerente General";
                        }else{
                            if($this->pgp_aprobacioncot_gerentegeneral == 0){
                                return "Aprobar cotizaciones Gerente General";
                            }else{
                                return "Subir oferta a la plataforma";
                            }
                        }
                    }
                }else{
                    return "Subir oferta a la plataforma";
                }
                break;
            case 15:
                return "Responder solicitud de revisión de montos de la(s) cotizaciones";
                break;
            case 16:
                return "Re-generar cotizaciones por rechazo";
                break;
            case 17:
                return "Subir oferta a la plataforma";
                break;
            case 18:
                return "Responder estado adjudicación";
                break;
            case 19:
                return "Licitación finalizada (no adjudicada)";
                break;
            case 20:
                return "Solicitar centro de costo";
                break;
            case 21:
                return "Ingresar centro de costo";
                break;
            case 22:
                return "Ingresar inicio ejecución servicio";
                break;
            case 23:
                return "Ingresar termino ejecución servicio";
                break;
            case 24:
                return "Envio solicitud cierre proyecto";
                break;
            case 25:
                return "Cerrar proyecto";
                break;
            case 26:
                return "Ingresar informe KPI de servicio";
                break;
            case 27:
                return "Cerrar centro de costo";
                break;
            case 28:
                return "Licitación finalizada (centro costo cerrado)";
                break;
        }
    }

    public function resp(){
        switch ($this->id_etapa) {
            case 0:
                return "N/D";
                break;
            case 1:
                return "Responsable (Administrador de Terreno)";
                break;
            case 2:
                return "Sub-Gerente Operaciones";
                break;
            case 3:
                return "Sub-Gerente Operaciones";
                break;
            case 4:
                return "Sub-Gerente Operaciones";
                break;
            case 5:
                return "";
                break;
            case 6:
                return "Responsable (Administrador de Terreno)";
                break;
            case 7:
                return "Responsable (Administrador de Terreno)";
                break;
            case 8:
                return "Sub-Gerente Operaciones";
                break;
            case 9:
                return "";
                break;
            case 10:
                return "Responsable (Administrador de Terreno)";
                break;
            case 11:
                return "Responsable (Administrador de Terreno)";
                break;
            case 12:
                return "Jefe Operaciones";
                break;
            case 13:
                return "Responsable (Administrador de Terreno)";
                break;
            case 14:
                if($this->id_tipo_licitacion == 4){
                    if($this->pgp_aprobacioncot_subgerenteoperaciones == 0){
                        return "Sub-Gerente Operaciones";
                    }else{
                        if($this->pgp_aprobacioncot_subgerentegeneral == 0){
                            return "Sub-Gerente General";
                        }else{
                            if($this->pgp_aprobacioncot_gerentegeneral == 0){
                                return "Gerente General";
                            }else{
                                return "Responsable (Administrador de Terreno)";
                            }
                        }
                    }
                }else{
                    return "Responsable (Administrador de Terreno)";
                }
                break;
            case 15:
                return "Sub-Gerente Operaciones";
                break;
            case 16:
                return "Responsable (Administrador de Terreno)";
                break;
            case 17:
                return "Responsable (Administrador de Terreno)";
                break;
            case 18:
                return "Responsable (Administrador de Terreno)";
                break;
            case 19:
                return "";
                break;
            case 20:
                return "Responsable (Administrador de Terreno)";
                break;
            case 21:
                return "Contabilidad";
                break;
            case 22:
                return "Responsable (Administrador de Terreno)";
                break;
            case 23:
                return "Responsable (Administrador de Terreno)";
                break;
            case 24:
                return "Responsable (Administrador de Terreno)";
                break;
            case 25:
                return "Jefe Operaciones";
                break;
            case 26:
                return "Sub-Gerente Operaciones";
                break;
            case 27:
                return "Contabilidad";
                break;
            case 28:
                return "";
                break;
        }
    }

}
