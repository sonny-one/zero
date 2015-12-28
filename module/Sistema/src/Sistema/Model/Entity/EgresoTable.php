<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class EgresoTable extends TableGateway
{
    private $origen;
    private $id_fondo;
    private $destino;
    private $id_proveedor;  
    private $monto;
    private $forma_pago;
    private $fecha_pago;
    private $nmro_operacion;
    private $id_banco;
    private $foto;
    private $observacion;
    private $id_tipo_egreso;
    private $concepto;
    private $user_create;
    private $cuotas;
    
    
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_egreso', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->id_fondo=$datos["origen"]; 
        $this->destino=$datos["destino"];
        $this->id_proveedor=$datos["id_proveedor"];    
        $this->monto=$datos["montototal"];
        $this->forma_pago=$datos["forma_pago"];
        $this->fecha_pago=$datos["fecha"];
        $this->nmro_operacion=$datos["nmrooperacion"];
        $this->id_banco=$datos["id_banco"];
		$this->observacion=$datos["observacion"];
        $this->foto=$datos["foto"];
		$this->id_tipo_egreso=$datos["id_tipo_egreso"];
        $this->concepto=$datos["concepto"];
		$this->user_create=$datos["user_create"];
        $this->cuotas=$datos["cuotas"];
        
    }
    
        public function nuevoEgreso($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_fondo'=>$this->id_fondo,
                'destino'=>$this->destino,
                'id_proveedor'=>$this->id_proveedor,
                'monto'=>$this->monto,
                'forma_pago'=>$this->forma_pago,
                'fecha_pago'=>$this->fecha_pago,
                'nmro_operacion'=>$this->nmro_operacion,
                'id_banco'=>$this->id_banco,
                'observacion'=>$this->observacion,
                'foto'=>$this->foto,
                'id_tipo_egreso'=>$this->id_tipo_egreso,
                'concepto'=>$this->concepto,                
                'user_create'=>$this->user_create,
                'cuotas'=>$this->cuotas,                                
                'activo'=> '1',
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        } 
    
    public function getDatosActivos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione su Departamento";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 
    public function getDatos()
    {
        
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getIdUnidad($nombre)
    {
        
        $datos = $this->select(array('nombre'=>$nombre));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getDatosId($llave)
    {
        
        $datos = $this->select(array('id'=>$llave));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getDatosxPersona($id_persona)
    {
        
        $datos = $this->select(array('id_persona'=>$id_persona));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
}