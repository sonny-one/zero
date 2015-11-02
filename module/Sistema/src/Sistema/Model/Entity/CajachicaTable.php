<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class CajachicaTable extends TableGateway
{
    private $id;
    private $saldo;
    private $importe;
    private $frecuencia;
    private $detalles;
    private $estado;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_caja_chica', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
    private function cargarCampos($datos=array())
    {    
        $this->saldo=$datos["saldo"];
        $this->importe=$datos["importe"];   
        $this->frecuencia=$datos["frecuencia"];
        $this->detalles=$datos["detalles"];
        $this->estado=$datos["estado"];
    }
                    
    public function getDatos()
    {                
        $datos = $this->select();
        $recorre = $datos->toArray();
        return $recorre;
    } 
            
    public function guardarCaja($id, $lista=array())
    {
        
        self::cargarCampos($lista);
        $array=array
             (
                'saldo'=>$this->saldo,
                'importe'=>$this->importe,
                'frecuencia'=>$this->frecuencia,
                'detalles'=>$this->detalles,
                'estado'=>$this->estado,
                
             );
        
        $this->update($array, array('id' => $id));
    } 
    public function nuevaCaja($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'saldo'=>$this->saldo,
                'importe'=>$this->importe,
                'frecuencia'=>$this->frecuencia,
                'detalles'=>$this->detalles,
                'estado'=>$this->estado,
                
             );
               $this->insert($array);                               
 
    } 
    
}
