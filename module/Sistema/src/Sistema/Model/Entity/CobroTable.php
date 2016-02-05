<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class CobroTable extends TableGateway
{
    private $id_egreso;
    private $cuota;
    private $valor; 
    private $fecha_cobro;    
    private $fecha_pago;
    private $nmro_operacion;    
    private $id_banco;    
    private $desc;
    private $estado;
    private $user_create;        
    private $activo;
    
    private $dbAdapter;
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_cobro', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->id_egreso=$datos["id_egreso"]; 
        $this->cuota=$datos["cuota"];  
        $this->valor=$datos["valor"];
        $this->fecha_cobro=$datos["fecha_cobro"];
        $this->fecha_pago=$datos["fecha_pago"];
        $this->nmro_operacion=$datos["nmro_operacion"];
        $this->id_banco=$datos["id_banco"];
		$this->desc=$datos["desc"];
        $this->user_create=$datos["user_create"];
        $this->activo=$datos["activo"];
        
    }
    
        public function nuevoCobro($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_egreso'=>$this->id_egreso,
                'cuota'=>$this->cuota,
                'valor'=>$this->valor,
                'fecha_cobro'=>$this->fecha_cobro,
                'fecha_pago'=>$this->fecha_pago,
                'nmro_operacion'=>$this->nmro_operacion,
                'id_banco'=>$this->id_banco,
                'desc'=>$this->desc,            
                'user_create'=>$this->user_create,                                                
                'activo'=> '1',
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        } 
    public function getCobros()
    {
        
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getCobroId($llave)
    {
        
        $datos = $this->select(array('id'=>$llave));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getCobroIdEgreso($id_egreso)
    {
        
        $datos = $this->select(array('id_egreso'=>$id_egreso,'activo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function borraEgreso($id)
    {             
        $array=array('activo'=>'0');
        $this->update($array,array('id_egreso'=>$id));                  
    }
    
    public function getSumaCuotas(Adapter $dbAdapter,$id_egreso)
    {         
         $this->dbAdapter=$dbAdapter;
         $query = "select sum(valor) as monto from sis_w_cobro where id_egreso = '$id_egreso' and estado <> 'impaga'";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();        
    }
    
}