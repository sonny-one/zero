<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class PersonaDetTable extends TableGateway
{
    
        private $id_persona;
        private $id_estacionamiento;
        private $id_bodega;
        private $id_unidad;
        private $condicion;
        private $activo;
        private $titular;
        private $date_update;
        private $user_create;
        private $representa;
        private $gastocomun;
    
 
    
    public $dbAdapter;
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_perdet', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->id_persona=$datos["id_persona"];
        $this->id_estacionamiento=$datos["id_estacionamiento"];   
        $this->id_bodega=$datos["id_bodega"];
        $this->id_unidad=$datos["id_unidad"];
        $this->condicion=isset($datos["condicion"])?$datos["condicion"]:"C";
        $this->activo=isset($datos["activo"])?$datos["activo"]:"1";
        $this->titular=isset($datos["titular"])?$datos["titular"]:"1";
        $this->date_update=$datos["date_update"];
        $this->user_create=isset($datos["user_create"])?$datos["user_create"]:"0";
        $this->representa=isset($datos["representa"])?$datos["representa"]:"s";
        $this->gastocomun=isset($datos["gastocomun"])?$datos["gastocomun"]:"1";
        
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
    
    public function getDatosPersonaDetalle($id_dpto,$id_persona)
    {
        
        $datos = $this->select(array('id_unidad'=>$id_dpto,'id_persona'=>$id_persona));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
     public function nuevaPersonaDetalle($data=array())

    {
            self::cargarCampos($data);
            
            $array=array
             (
                'id_persona'=>$this->id_persona,
                'id_estacionamiento'=>$this->id_estacionamiento,
                'id_bodega'=>$this->id_bodega,
                'id_unidad'=>$this->id_unidad,
                'condicion'=>$this->condicion,
                'activo'=>$this->activo,
                'titular'=>$this->titular,
                'date_update'=>$this->date_update,
                'user_create'=>$this->user_create,
                'representa'=>$this->representa,
                'gastocomun'=>$this->gastocomun
                
             );

               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
               
        }

    public function getListadoResidentes(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $query = "select 
                concat(p1.nombre,' ',p1.apellido,' ',p1.apellido_2) as nombres,
                p1.telefono,p.condicion,p1.correo,
                concat(p1.rut,'-',p1.dv) as rutc,
                (select nombre from sis_m_unidad u where u.id=p.id_unidad) as unidad,
                (select nombre from sis_m_estacionamiento e where e.id=p.id_estacionamiento) as estacionamiento,
                (select nombre from sis_m_bodega b where b.id=p.id_bodega) as bodega
                from sis_w_perdet p,thouseap_general.sis_m_persona p1
                where p.id_persona = p1.id and activo=1";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
    }

}