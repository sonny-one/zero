<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class AbonoTable extends TableGateway
{         
    private $id_unidad;
    private $monto;
    private $fecha_pago;
    private $forma_pago;
    private $id_banco;
    private $nmrooperacion;
    private $nmrocheque;        
    private $comentario;

    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_abono', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())

    {    
		$this->id_unidad=$datos["id_unidad"];
        $this->monto=$datos["monto_abono"];   
        $this->fecha_pago=$datos["fecha_pago"];
        $this->forma_pago=$datos["forma_pago_abono"];
        $this->id_banco=$datos["banco_abono"];
        $this->nmrooperacion=$datos["nmrooperacion"];                 
        $this->comentario=$datos["comentario_abono"];

    }   
    
    public function nuevoAbono($datos)
    {
             self::cargarCampos($datos);
             $array=array
             (
                'id_unidad'=>$this->id_unidad,
                'monto'=>$this->monto,
                'fecha_pago'=>$this->fecha_pago,
                'forma_pago'=>$this->forma_pago,
                'id_banco'=>$this->id_banco,
                'nmro_operacion'=>$this->nmrooperacion, 
                'comentario'=>$this->comentario,
                'activo'=>'1'
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;                              
    }
    
    public function UsoAbono($id_abono)
    {
               $array=array('activo'=>'0');
               $this->update($array,array('id'=>$id_abono));
               $id = $this->lastInsertValue;
               return $id;                              
    }
        
    public function getDatos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function getAbonosUnidad($id_unidad)
    {
         $datos = $this->select(array('activo'=>'1','id_unidad'=>$id_unidad));
        $recorre = $datos->toArray();
        return $recorre;         
    }
    
    public function getAbonosActivos(Adapter $dbAdapter,$id_unidad)
    {
         $this->dbAdapter=$dbAdapter;
         $query = "select sum(monto) as monto from sis_w_abono where
                    id_unidad = '$id_unidad'
                    and activo = '1'";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         $recorre = $result->toArray();
         return $recorre;         
    }

}