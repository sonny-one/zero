<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class ProveedorTable extends TableGateway
{
    private $nombre;
    private $rut;
    private $dv;
    private $telefono;
    private $direccion;
    private $ciudad;
    private $correo;
    private $id_servicio;
    private $fijo;
    private $id_banco;
    private $nmro_cliente;
    private $observacion;
    private $activo;
    
    public $dbAdapter;
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_proveedor', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->nombre=$datos["nombre"];
        $this->rut=$datos["rut"];
        $this->dv=$datos["dv"];   
        $this->telefono=$datos["telefono"];
        $this->direccion=$datos["direccion"];
        $this->correo=$datos["correo"];
		$this->ciudad=$datos["ciudad"];
		$this->id_servicio=$datos["servicio"];
        $this->fijo=$datos["fijo"];
        $this->id_banco=$datos["id_banco"];
		$this->nmro_cliente=$datos["nmro_cliente"];
		$this->observacion=$datos["observacion"];
		$this->activo=$datos["activo"];
        
    }
    
    public function nuevoProveedor($data=array())
    {
       self::cargarCampos($data);
       $array=array
             (
              'nombre'=>$this->nombre,
              'rut'=>$this->rut,
              'dv'=>$this->dv,   
              'telefono'=>$this->telefono,
              'direccion'=>$this->direccion,
              'correo'=>$this->correo,
              'ciudad'=>$this->ciudad,
              'id_servicio'=>$this->id_servicio,
              'fijo'=>$this->fijo,
              'id_banco'=>$this->id_banco,
              'nmro_cliente'=>$this->nmro_cliente,
              'observacion'=>$this->observacion,                           
              'activo'=>'1'
        
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        } 
    
    public function getProveedoresCombo(Adapter $dbAdapter){

         $this->dbAdapter=$dbAdapter;
         $query = "select distinct(nombre) from sis_w_proveedor";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         $recorre = $result->toArray();
         $resultado["0"]="Seleccione un Proveedor";
            for($i=1;$i<=count($recorre);$i++)
                {
                    $resultado[$i] = $recorre[$i-1]['nombre']; 
                }
            return $resultado;
    }
    
    
    public function getProveedoresCombo2()
    {
        $datos = $this->select(array('activo'=>'1',));
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione un Proveedor";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 
    public function getProveedores()
    {
        
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getProveedoresFijo()
    {
        
        $datos = $this->select(array('activo'=>'1','fijo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getProveedoresRut($rut)
    {
        
        $datos = $this->select(array('rut'=>$rut));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getProveedoresId($id)
    {
        
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getProveedoresNombre($nombre)
    {
        
        $datos = $this->select(array('nombre'=>$nombre));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function eliminarProveedor($id)
    {            
        $this->update(array('activo'=>'0'),array('id'=>$id));
    }
    
}