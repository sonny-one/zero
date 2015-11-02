<?php

namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class BodegaTable extends TableGateway

{
        
    private $mts;
    private $piso;
    private $nombre;
    private $estado;
    private $alicuota;
    private $user_create;
    private $descripcion;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_bodega', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
     private function cargarCampos($datos=array())
    {    
        $this->mts=$datos["mts"];
        $this->piso=$datos["piso"];
        $this->nombre=$datos["nombre"];
        $this->estado=$datos["estado"];
        $this->alicuota=$datos["alicuota"];
        $this->user_create=$datos["user_create"];
        $this->descripcion=$datos["descripcion"];
           
    } 
    
    public function getDatosId($id)
    {
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
        return $recorre;
    }
    
    public function getBodegas()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    
     public function getDatosActivos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione Bodega";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 
    
    public function nuevaBodega($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'mts'=>$this->mts,
                'piso'=>$this->piso,
                'nombre'=>$this->nombre,
                'estado'=>$this->estado,
                'alicuota'=>$this->alicuota,
                'user_create'=>$this->user_create,
                'descripcion'=>$this->descripcion,             
                'activo'=>'1'                
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        }

}