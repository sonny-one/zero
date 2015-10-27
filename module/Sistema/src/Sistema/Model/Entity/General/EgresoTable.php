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
    private $monto;
    private $forma_pago;
    private $fecha_pago;
    private $nmro_operacion;
    private $id_banco;
    private $foto;
    private $observacion;
    private $tipo_ingreso;
    private $user_create;
    
    
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_egreso', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->origen=$datos["origen"];
        $this->fondo=$datos["fondo"];   
        $this->monto=$datos["monto"];
        $this->forma_pago=$datos["forma_pago"];
        $this->fecha_pago=$datos["fecha"];
        $this->nmro_operacion=$datos["nmro_operacion"];
        $this->id_banco=$datos["id_banco"];
		$this->observacion=$datos["observacion"];
        $this->foto=$datos["imgpagoprov"];
		$this->tipo_ingreso=$datos["tipo_ingreso"];
		$this->user_create=$datos["user_create"];
        
    }
    
        public function nuevoIngreso($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'origen'=>$this->origen,
                'fondo'=>$this->fondo,
                'monto'=>$this->monto,
                'forma_pago'=>$this->forma_pago,
                'fecha_pago'=>$this->fecha_pago,
                'nmro_operacion'=>$this->nmro_operacion,
                'banco'=>$this->banco,
                'observacion'=>$this->observacion,
                'foto'=>$this->foto,
                'tipo_ingreso'=>$this->tipo_ingreso,                
                'user_create'=>$this->user_create,                                
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