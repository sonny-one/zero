<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class UnidadTable extends TableGateway
{
    private $nombre;
    private $tipo;
    private $piso;    
    private $mts;
    private $alicuota;
    private $habitaciones;
    private $banos;
    private $estado;
    private $descripcion;
    private $user_create; 
    
    public $dbAdapter;
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_unidad', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
         
    private function cargarCampos($datos=array())
    {    
        $this->nombre=$datos["nombre"];        
        $this->piso=$datos["piso"];   
        $this->tipo=$datos["tipo"];
        $this->mts=$datos["mts"];
        $this->alicuota=$datos["alicuota"];
        $this->habitaciones=$datos["habitaciones"];
        $this->banos=$datos["banos"];
        $this->estado=$datos["estado"];
        $this->descripcion=$datos["descripcion"];   
        $this->user_create=$datos["user_create"];
        
    }
    
    public function getDatosActivos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione Departamento";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 
    public function getUnidades()
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
    
    public function getVerDpto(Adapter $dbAdapter,$idUnidad){
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT 
                pd.titular,
                pd.condicion,
                (select nombre from sis_m_unidad u where u.id=pd.id_unidad) as dpto,
                (select concat(nombre,' ',apellido, ' ',apellido_2) 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as nombre,
                (select correo 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as correo,
                (select telefono 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as contacto 
                FROM sis_w_perdet pd 
                where id_unidad=".$idUnidad." and activo=1
                union
                SELECT pd.titular,
                pd.condicion,
                (select nombre from sis_m_unidad u where u.id=pd.id_unidad) as dpto,
                (select concat(nombre,' ',apellido, ' ',apellido_2) 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as nombre,
                (select correo 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as correo,
                (select telefono 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as contacto 
                FROM sis_w_perdet pd  where id_unidad=".$idUnidad." and condicion='C' and activo in (0,1)";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
        
    }
    
        public function getVerResidentesActivos(Adapter $dbAdapter,$idUnidad){
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT 
                pd.titular,
                pd.condicion,
                (select nombre from sis_m_unidad u where u.id=pd.id_unidad) as dpto,
                (select concat(nombre,' ',apellido, ' ',apellido_2) 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as nombre,
                (select correo 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as correo,
                (select telefono 
                from thouseap_general.sis_m_persona p where p.id=pd.id_persona)  as contacto 
                FROM sis_w_perdet pd 
                where id_unidad=".$idUnidad." and activo=1
                ";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
        
    }
    
    public function nuevaUnidad($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'nombre'=>$this->nombre,
                'piso'=>$this->piso,
                'tipo'=>$this->tipo,
                'mts'=>$this->mts,
                'alicuota'=>$this->alicuota,
                'habitaciones'=>$this->habitaciones,
                'banos'=>$this->banos,
                'estado'=>$this->estado,             
                'descripcion'=>$this->descripcion,
                'user_create'=>$this->user_create,
                'activo'=>'1',                                  
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        }


    

}