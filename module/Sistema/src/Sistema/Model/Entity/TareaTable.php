<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class TareaTable extends TableGateway
{
    
    private $nombre;
    private $urgente;
    private $area_responsable;
    private $responsable;
    private $pago;
    private $estado;
    private $avance;
    private $fecha;
    private $user_create;
   
    public $dbAdapter;
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_tarea', $adapter, $databaseSchema,$selectResultPrototype);
    }


    private function cargarCampos($datos=array())
    {       
        $this->nombre=$datos["nombre"];
        $this->urgente=$datos["urgente"];
        $this->area_responsable=$datos["area_responsable"];
        $this->responsable=$datos["responsable"];
        $this->pago=$datos["pago"];
        $this->estado=$datos["estado"];
        $this->avance=$datos["avance"];
        $this->fecha=$datos["fecha"];
        $this->user_create=$datos["user_create"];                    
    }
    
    public function nuevaTarea($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (

                'nombre'=>$this->nombre,
                'urgente'=>$this->urgente,
                'area_responsable'=>$this->area_responsable,
                'responsable'=>$this->responsable,
                'pago'=>$this->pago,
                'estado'=>$this->estado,
                'avance'=>$this->avance,
                'fecha'=>$this->fecha,
                'user_create'=>$this->user_create,
                'activo'=>'1',
             );
               $this->insert($array);   
               $id = $this->lastInsertValue;
               return $id;
               
    }
    
    public function editarTarea($id,$data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'nombre'=>$this->nombre,
                'urgente'=>$this->urgente,
                'area_responsable'=>$this->area_responsable,
                'responsable'=>$this->responsable,
                'pago'=>$this->pago,
                'estado'=>$this->estado,
                'avance'=>$this->avance,
                'fecha'=>$this->fecha,
                'user_create'=>$this->user_create,
                'date_update'=>date('Y-m-d h:m:s'),
             );
               $this->update($array,array('id'=>$id));                  
    }
    
    public function getTareas()
    {
        
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getTareasgc()
    {
        
        $datos = $this->select(array('activo'=>'1','pago'=>'aplica'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getTareasMes(Adapter $dbAdapter,$fecha_inicio,$fecha_cierre)
    {
       $this->dbAdapter = $dbAdapter;
       $query = "SELECT * FROM sis_w_tarea WHERE fecha BETWEEN '".$fecha_inicio."'  AND '".$fecha_cierre."';";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
    }
    
    public function getTareasId($id)
    {
        
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function eliminaTarea($id)
    {
        
        $datos = $this->update(array('activo'=>'0'),array('id'=>$id));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
   
    
}