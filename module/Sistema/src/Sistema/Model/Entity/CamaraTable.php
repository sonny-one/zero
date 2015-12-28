<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class CamaraTable extends TableGateway
{     
    private $camaras;
    private $graban;
    private $reglas;
    private $user_create;

    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_m_camara', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())

    {    
		$this->camaras=$datos["camaras"];
        $this->graban=$datos["graban"];   
        $this->reglas=$datos["reglas"];
        $this->user_create=$datos["user_create"];
    }   
    
        public function nuevaCamara($datos)
    {
             self::cargarCampos($datos);
             $array=array
             (
                'camaras'=>$this->camaras,
                'graban'=>$this->graban,
                'reglas'=>$this->reglas,
                'user_create'=>$this->user_create,             
                'activo'=>'1'
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;                              
    }
    
    public function editarCamara($id,$data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'camaras'=>$this->camaras,
                'graban'=>$this->graban,
                'reglas'=>$this->reglas,  
                'date_update'=>date('Y-m-d h:m:s'),
             );
               $this->update($array,array('id'=>$id));                  
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