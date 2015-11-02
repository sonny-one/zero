<?php

namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;



class VisitaTable extends TableGateway

{

    private $id_unidad;
    private $id_persona_t;
    private $id_persona_v;
    private $id_estacionamiento;
    private $id_motivo;
    private $fecha_ingreso;
    private $fecha_salida;
    private $modelo_auto;
    private $patente;
    private $observacion;
    private $aplica_multa;
    private $hora_diferencia;
    private $deuda;
    private $estado;
    private $user_create;
    private $user_update;
    private $date_update;
   
    
    public $dbAdapter;
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_visita', $adapter, $databaseSchema,$selectResultPrototype);

    }

    private function cargarCampos($datos=array())

    {    
        $this->id_unidad=isset($datos["id_unidad"])?$datos["id_unidad"]:"0";
        $this->id_persona_t=isset($datos["id_persona_t"])?$datos["id_persona_t"]:"0";
        $this->id_persona_v=isset($datos["id_persona_v"])?$datos["id_persona_v"]:"0";
        $this->id_estacionamiento=isset($datos["id_estacionamiento"])?$datos["id_estacionamiento"]:"0";
        $this->id_motivo=isset($datos["id_motivo"])?$datos["id_motivo"]:"0";
        $this->fecha_ingreso=isset($datos["fecha_ingreso"])?$datos["fecha_ingreso"]:"";
        $this->fecha_salida=isset($datos["fecha_salida"])?$datos["fecha_salida"]:"";
        $this->modelo_auto=isset($datos["modelo_auto"])?$datos["modelo_auto"]:"";
        $this->patente=isset($datos["patente"])?$datos["patente"]:"";
        $this->observacion=isset($datos["observacion"])?$datos["observacion"]:"";
        $this->aplica_multa=isset($datos["aplica_multa"])?$datos["aplica_multa"]:"";
        $this->hora_diferencia=isset($datos["hora_diferencia"])?$datos["hora_diferencia"]:"0";
        $this->deuda=isset($datos["deuda"])?$datos["deuda"]:"0";
        $this->estado=isset($datos["estado"])?$datos["estado"]:"Abierto";
        $this->user_create=isset($datos["user_create"])?$datos["user_create"]:"0";
        $this->user_update=isset($datos["user_update"])?$datos["user_update"]:"0";
        $this->date_update=isset($datos["date_update"])?$datos["date_update"]:null;

    }

    

    public function nuevaVisita($data=array()){
        
        self::cargarCampos($data);
             $array=array
             (
                'id_unidad'=>$this->id_unidad,
                'id_persona_t'=>$this->id_persona_t,
                'id_persona_v'=>$this->id_persona_v,
                'id_estacionamiento'=>$this->id_estacionamiento,
                'id_motivo'=>$this->id_motivo,
                'fecha_ingreso'=>$this->fecha_ingreso,
                'fecha_salida'=>$this->fecha_salida,                
                'modelo_auto'=>$this->modelo_auto,
                'patente'=>$this->patente,
                'observacion'=>$this->observacion,                                
                'aplica_multa'=>$this->aplica_multa,
                'hora_diferencia'=>$this->hora_diferencia,
                'deuda'=>$this->deuda,
                'estado'=>$this->estado,
                'user_create'=>$this->user_create,
                'user_update'=>$this->user_update,
                'date_update'=>$this->date_update,
             );

               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        
    }
    
    
    public function getListaUltimasVisitas (Adapter $dbAdapter){
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT 
                (select nombre from sis_m_unidad u where u.id=v.id_unidad) as dpto ,
                (select concat(nombre,' ',apellido,' ',apellido_2) from thouseap_general.sis_m_persona p where p.id=v.id_persona_v) as nombres,
                v.fecha_ingreso,
                (case  WHEN v.id_estacionamiento>0 THEN 'Si' ELSE 'No' END)  as con_auto,
                v.estado,v.patente
                FROM sis_w_visita v order by date_update desc limit 50 ";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
        
    }
    
     public function actualizarVisitaEst($data=array())
    {
         
             $array=array
             (
                'estado'=>'Cerrado',
                'hora_diferencia'=>$data['hora_diferencia'],
                'user_update'=>$data['user_update'],
                'fecha_salida'=>$data['fecha_salida'],
                'date_update'=>$data['fecha_salida']
                
             );
        
        $this->update($array, array('id' => $data['id_visita']));
    }

    

}