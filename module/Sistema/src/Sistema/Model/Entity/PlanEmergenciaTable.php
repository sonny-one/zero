<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class PlanEmergenciaTable extends TableGateway
{     
    private $url;
    private $estado;
    private $user_create;

    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_m_plan_emergencia', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())

    {    
		$this->url=$datos["url_plan"];        
        $this->user_create=$datos["user_create"];
    }   
    
        public function nuevoPlan($datos)
    {
             self::cargarCampos($datos);
             $array=array
             (
                'url'=>$this->url,                
                'user_create'=>$this->user_create,             
                'activo'=>'1'
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;                              
    }
    
    public function getDatos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    
    public function getActivoId($id)
    {
        $datos = $this->select(array('id'=>$id,'activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;          
    }

    

}