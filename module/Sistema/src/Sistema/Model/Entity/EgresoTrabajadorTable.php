<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class EgresoTrabajadorTable extends TableGateway
{

    private $id_egreso;
    private $id_trabajador;
    private $leyes_sociales;  
    private $sueldo;
    private $monto;    
      
    
    public $dbAdapter;   
    
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_egreso_trabajador', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->id_egreso=$datos["id_egreso"]; 
        $this->id_trabajador=$datos["id_trabajador"];
        $this->leyes_sociales=$datos["leysocial"];    
        $this->sueldo=$datos["sueldo"];              
        $this->monto=$datos["montototal"];        
        
    }
    public function nuevoEgresoTrabajador($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_egreso'=>$this->id_egreso,
                'id_trabajador'=>$this->id_trabajador,
                'leyes_sociales'=>$this->leyes_sociales,
                'sueldo'=>$this->sueldo,
                'monto'=>$this->monto,                                                  
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        } 
    
     public function getPagoPeriodo(Adapter $dbAdapter,$id_trabajador)
    {        
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT e.monto, e.fecha_pago as fecha_pago, et.id_tipo_egreso_trabajador
                    FROM sis_w_egreso_trabajador et, sis_w_egreso e, sis_m_cierre_mes cm
                    WHERE et.id_trabajador='$id_trabajador'
                    and et.id_egreso = e.id
                    and e.fecha_pago between cm.fecha_inicio and  cm.fecha_cierre";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
    }
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
       public function nuevoEgreso($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_fondo'=>$this->id_fondo,
                'destino'=>$this->destino,
                'monto'=>$this->monto,

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
     
    public function getDatos2()
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