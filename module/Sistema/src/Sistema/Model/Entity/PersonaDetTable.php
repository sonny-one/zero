<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class PersonaDetTable extends TableGateway
{
    private $id_persona;
    private $id_est;
    private $id_bodega;
    private $id_unidad;
    private $condicion;
    private $activo;
    private $user_create;
    private $representa;
    
    public $dbAdapter;
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_perdet', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->id_persona=$datos["id_persona"];
        $this->id_est=$datos["id_est"];   
        $this->id_bodega=$datos["id_bodega"];
        $this->id_unidad=$datos["id_unidad"];
        $this->condicion=$datos["condicion"];
        $this->activo=$datos["activo"];
        $this->user_create=$datos["user_create"];
        $this->representa=$datos["representa"];
        
    }

    public function getDatos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getDatosUnidad($id_dpto)
    {
        
        $datos = $this->select(array('id_unidad'=>$id_dpto));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    public function getDatosxPersona($id_persona)
    {
        
        $datos = $this->select(array('id_persona'=>$id_persona));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getTitularDpto($id_unidad){
        $datos = $this->select(array('id_unidad'=>$id_unidad,'activo'=>1,'titular'=>1));
        $recorre = $datos->toArray();
        return $recorre;
    }
    
    public function getHabitanDpto(Adapter $dbAdapter,$id_unidad)
    {
        $this->dbAdapter = $dbAdapter;
        $query = "select 
                    concat(p1.nombre,' ',p1.apellido,' ',p1.apellido_2) as nombres,
                    p1.telefono,p.condicion,p1.correo
                    from sis_w_perdet p,thouseap_general.sis_m_persona p1
                    where p.id_unidad=".$id_unidad." and p.id_persona = p1.id and activo=1";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
    }

    

}