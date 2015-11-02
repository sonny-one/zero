<?php

namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class EstacionamientoTable extends TableGateway

{
    private $nombre;
    private $piso;
    private $tipo;
    private $mts;
    private $alicuota;
    private $estado;
    private $descripcion;
    private $user_create;
    
    public $dbAdapter;
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_estacionamiento', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
    private function cargarCampos($datos=array())

    {    
        $this->nombre=$datos["nombre"];        
        $this->piso=$datos["piso"];   
        $this->tipo=$datos["tipo"];
        $this->mts=$datos["mts"];
        $this->alicuota=$datos["alicuota"];
        $this->estado=$datos["estado"];
        $this->descripcion=$datos["descripcion"];   
        $this->user_create=$datos["user_create"];                        

    }
                        
    public function getDatosId($id)
    {
        
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getEstacionamientos()
    {
        
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getDatosActivos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione Estacionamiento";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 

    public function getEstVist(Adapter $dbAdapter){
        
        $this->dbAdapter=$dbAdapter;
         
        $query = "select e.id as pk,v.id_visita,e.nombre,v.id_unidad,
                (select u.nombre from sis_m_unidad u where u.id=v.id_unidad) as nombre_unidad,
                v.patente,
                v.id as id_est_visita,
                e.estado,v.fecha_ingreso as fecha,
                v.aplica_multa as aplica,truncate(Timestampdiff(second,v.fecha_ingreso,now())/3600,2) as horas
                from sis_m_estacionamiento e left join sis_w_est_visita v on 
                v.id_estacionamiento =e.id where e.activo='1' and e.tipo='VISITA' order by pk";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();        
                
    }
    
    public function bloquearEst($data){
         $array=array
             (
                'estado'=>'2',
                'date_update'=>$data['date_update']
                
             );
        
        $this->update($array, array('id' => $data['id']));
    }
    public function desbloquearEst($data){
         $array=array
             (
                'estado'=>'1',
                'date_update'=>$data['date_update']
                
             );
        
        $this->update($array, array('id' => $data['id']));
    } 
    
    public function nuevoEstacionamiento($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'nombre'=>$this->nombre,
                'piso'=>$this->piso,
                'tipo'=>$this->tipo,
                'mts'=>$this->mts,
                'alicuota'=>$this->alicuota,
                'estado'=>$this->estado,             
                'descripcion'=>$this->descripcion,
                'user_create'=>$this->user_create,
                'activo'=>'1',                                  
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        }   

}