<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class IngresoTable extends TableGateway
{
    private $origen;
    private $id_fondo;
    private $monto;
    private $forma_pago;
    private $fecha_pago;
    private $nmro_operacion;
    private $banco;
    private $observacion;
    private $tipo_ingreso;
    private $user_create;
    
    
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_ingreso', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->origen=$datos["origen"];
        $this->id_fondo=$datos["id_fondo"];   
        $this->monto=$datos["monto"];
        $this->forma_pago=$datos["forma_pago"];
        $this->fecha_pago=$datos["fecha"];
        $this->nmro_operacion=$datos["nmro_operacion"];
        $this->banco=$datos["banco"];
		$this->observacion=$datos["observacion"];
		$this->tipo_ingreso=$datos["tipo_ingreso"];
		$this->user_create=$datos["user_create"];
        
    }
    
        public function nuevoIngreso($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'origen'=>$this->origen,
                'id_fondo'=>$this->id_fondo,
                'monto'=>$this->monto,
                'forma_pago'=>$this->forma_pago,
                'fecha_pago'=>$this->fecha_pago,
                'nmro_operacion'=>$this->nmro_operacion,
                'banco'=>$this->banco,
                'observacion'=>$this->observacion,
                'tipo_ingreso'=>$this->tipo_ingreso,                
                'user_create'=>$this->user_create,                                
                'activo'=> '1',
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
    
    
}