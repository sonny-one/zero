<?php

namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;



class EncomiendaTable extends TableGateway

{

    private $id_unidad;
    private $id_persona_remite;
    private $id_persona_retira;
    private $detalle;
    private $foto;
    private $observacion;
    private $estado;
    private $activo;
    private $fecha_ingreso;
    private $fecha_salida;
    private $date_update;  
    private $user_create;  
    private $user_update;
    

   
    
    public $dbAdapter;
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_encomienda', $adapter, $databaseSchema,$selectResultPrototype);

    }

    private function cargarCampos($datos=array())

    {    
            
        $this->id_unidad=isset($datos["id_unidad"])?$datos["id_unidad"]:null;
        $this->id_persona_remite=isset($datos["id_persona_remite"])?$datos["id_persona_remite"]:null;
        $this->id_persona_retira=isset($datos["id_persona_retira"])?$datos["id_persona_retira"]:null;
        $this->detalle=isset($datos["detalle"])?$datos["detalle"]:"";
        $this->foto=isset($datos["foto"])?$datos["foto"]:"";
        $this->observacion=isset($datos["observacion"])?$datos["observacion"]:"";
        $this->estado=isset($datos["estado"])?$datos["estado"]:"Abierto";
        $this->activo=isset($datos["activo"])?$datos["activo"]:"1";
        $this->fecha_ingreso=isset($datos["fecha_ingreso"])?$datos["fecha_ingreso"]:"";
        $this->fecha_salida=isset($datos["fecha_salida"])?$datos["fecha_salida"]:"";
        $this->date_update=isset($datos["date_update"])?$datos["date_update"]:"";
        $this->user_create=isset($datos["user_create"])?$datos["user_create"]:null;
        $this->user_update=isset($datos["user_update"])?$datos["user_update"]:null;

    }

    

    public function nuevaEncomienda($data=array()){
        
        self::cargarCampos($data);
             $array=array
             (
                'id_unidad'=>$this->id_unidad,
                'id_persona_remite'=>$this->id_persona_remite,
                'id_persona_retira'=>$this->id_persona_retira,
                'detalle'=>$this->detalle,
                'observacion'=>$this->observacion,
                'estado'=>$this->estado,
                'activo'=>$this->activo, 
                'foto'=>$this->foto,               
                'fecha_ingreso'=>$this->fecha_ingreso,
                'fecha_salida'=>$this->fecha_salida,
                'date_update'=>$this->date_update,                                
                'user_create'=>$this->user_create,
                'user_update'=>$this->user_update
             );

               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        
    }
    
    
    public function getUltimasEncAbierta(Adapter $dbAdapter){
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT id,
                (select p1.rut  from thouseap_general.sis_m_persona p1,sis_w_perdet p2 where p1.id=p2.id_persona and p2.activo=1 and p2.titular=1 and p2.id_unidad=v.id_unidad limit 1) as rut_titular,
                (select p1.dv  from thouseap_general.sis_m_persona p1,sis_w_perdet p2 where p1.id=p2.id_persona and p2.activo=1 and p2.titular=1 and p2.id_unidad=v.id_unidad limit 1) as dv_titular,
                (select concat(p1.nombre,' ',p1.apellido,' ',p1.apellido_2)  from thouseap_general.sis_m_persona p1,sis_w_perdet p2 where p1.id=p2.id_persona and p2.activo=1 and p2.titular=1 and p2.id_unidad=v.id_unidad limit 1) as nombre_titular,
                (select id_persona from sis_w_perdet p where p.activo=1 and p.titular=1 and p.id_unidad=v.id_unidad limit 1) as id_persona,
                (select nombre from sis_m_unidad u where u.id=v.id_unidad) as dpto ,
                (select concat(nombre,' ',apellido,' ',apellido_2) from thouseap_general.sis_m_persona p where p.id=v.id_persona_remite) as nombres,
                v.fecha_ingreso,
                v.detalle,
                case when length(v.detalle)>15 then concat(substring(v.detalle,1,15),'...') else v.detalle end as detalle_corto,
                v.foto,
                case when length(v.foto)>15 then concat(substring(v.foto,1,15),'...') else v.foto end as foto_corto
                FROM sis_w_encomienda v where v.activo=1 and v.estado='Abierto' order by date_update desc limit 50";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
        
    }
    
    
    public function listarEncomiendas(Adapter $dbAdapter,$estado,$dpto,$limit)
    {
        if($estado!=""){
            $estado_1=" and v.estado in (";
            $v=explode(",",$estado);
            for($i=0;$i<count($v);$i++){
                if($i==count($v)-1){
                    $estado_1=$estado_1."'".$v[$i]."'";
                }else{
                    $estado_1=$estado_1."'".$v[$i]."',";
                }
            }
            $estado_1=$estado_1.") ";
        }else{
            $estado_1="";    
        }
         
        $limit_1 = $limit!=""?" limit ".$limit:"";
        $dpto_1 = $dpto!=""?" and v.id_unidad in (select uu.id from sis_m_unidad uu where uu.nombre='".$dpto."' and uu.activo=1 ) ":"";
        
        
        
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT v.id,
                    v.id_unidad,                
                    v.fecha_ingreso,
                    v.id_persona_remite,
                    v.id_persona_retira,
                (select p1.rut  from thouseap_general.sis_m_persona p1,sis_w_perdet p2 where p1.id=p2.id_persona and p2.activo=1 and p2.titular=1 and p2.id_unidad=v.id_unidad limit 1) as rut_titular,
                (select p1.dv  from thouseap_general.sis_m_persona p1,sis_w_perdet p2 where p1.id=p2.id_persona and p2.activo=1 and p2.titular=1 and p2.id_unidad=v.id_unidad limit 1) as dv_titular,
                (select concat(p1.nombre,' ',p1.apellido,' ',p1.apellido_2)  from thouseap_general.sis_m_persona p1,sis_w_perdet p2 where p1.id=p2.id_persona and p2.activo=1 and p2.titular=1 and p2.id_unidad=v.id_unidad limit 1) as nombre_titular,
                (select id_persona from sis_w_perdet p where p.activo=1 and p.titular=1 and p.id_unidad=v.id_unidad limit 1) as id_persona,
                    (select nombre from sis_m_unidad u where u.id=v.id_unidad) as dpto ,
                    (select concat(nombre,' ',apellido,' ',apellido_2) 
                    from thouseap_general.sis_m_persona p where p.id=v.id_persona_remite) as nombres,
                    v.estado
                    FROM sis_w_encomienda v where v.activo=1 ".$estado_1." ".$dpto_1." order by date_update desc ".$limit_1;
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
      
        
    }    
    
     public function cerrarEncomienda($data=array())
    {
         
             $array=array
             (
                'estado'=>'Cerrado',
                'id_persona_retira'=>$data['id_persona_retira']==''?null:$data['id_persona_retira'],
                'user_update'=>$data['user_update'],
                'fecha_salida'=>$data['fecha_salida'],
                'date_update'=>$data['fecha_salida'],
                'observacion'=>$data['observacion']
                
             );
        
        $this->update($array, array('id' => $data['id_encomienda']));
    }
    
    public function detalleEnconmienda(Adapter $dbAdapter,$id)
    {
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT  
                    (select nombre from sis_m_unidad where id=w.id_unidad) as dpto,
                    (select concat(p.nombre,' ',p.apellido,' ',p.apellido_2) from thouseap_general.sis_m_persona p where p.id=w.id_persona_remite) as remite,
                    (select concat(p.nombre,' ',p.apellido,' ',p.apellido_2) from thouseap_general.sis_m_persona p where p.id=w.id_persona_retira) as retira,
                     w.fecha_ingreso,w.foto,w.detalle,w.observacion,w.date_update,w.estado,
                    (select concat(p.nombre,' ',p.apellido,' ',p.apellido_2) FROM thouseap_general.sis_m_usuario u,thouseap_general.sis_m_persona p where u.id_persona = p.id and u.id=w.user_create) as registrado,
                    (select concat(p.nombre,' ',p.apellido,' ',p.apellido_2) FROM thouseap_general.sis_m_usuario u,thouseap_general.sis_m_persona p where u.id_persona = p.id and u.id=w.user_update) as actualizado
                    FROM sis_w_encomienda w where id=".$id;
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
    }

    

}