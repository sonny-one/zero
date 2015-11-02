<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class MultaTable extends TableGateway
{
    private $id;
    private $tipo_cobro;
    private $valor;
    private $ruidos;
    private $mascota;
    private $visita;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_multa', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
    private function cargarCampos($datos=array())
    {    
        $this->tipo_cobro=$datos["tipo_cobro"];
        $this->valor=$datos["valor"];   
        $this->ruidos=$datos["ruidos"];
        $this->mascota=$datos["mascota"];
        $this->visita=$datos["visita"];
    }
                    
    public function getDatos()
    {                
        $datos = $this->select();
        $recorre = $datos->toArray();
        return $recorre;
    } 
            
    public function guardarMulta($id, $lista=array())
    {
        
        self::cargarCampos($lista);
        $array=array
             (
                'tipo_cobro'=>$this->tipo_cobro,
                'valor'=>$this->valor,
                'ruidos'=>$this->ruidos,
                'mascota'=>$this->mascota,
                'visita'=>$this->visita,
                
             );
        
        $this->update($array, array('id' => $id));
    } 
    public function nuevaMulta($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'tipo_cobro'=>$this->tipo_cobro,
                'valor'=>$this->valor,
                'ruidos'=>$this->ruidos,
                'mascota'=>$this->mascota,
                'visita'=>$this->visita,
                
             );
               $this->insert($array);                               
 
    } 
    
}
