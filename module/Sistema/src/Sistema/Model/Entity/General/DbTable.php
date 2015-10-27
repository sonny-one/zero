<?php
namespace Sistema\Model\Entity\General;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class DbTable extends TableGateway
{
    private $id;
    private $nombre_db;
    private $nombre;
    private $foto;
    private $icono;
    private $descripcion;
    private $info;
    private $activo;
    private $date_update;
    private $user_create;

    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_db', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
         private function cargarCampos($datos=array())
    {    
        $this->nombre_db=$datos["nombre_db"];
        $this->nombre=$datos["nombre"];   
        $this->foto=$datos["foto"];
        $this->icono=$datos["icono"];
        $this->descripcion=$datos["descripcion"];
        $this->info=$datos["info"];
        $this->activo=$datos["activo"];
        $this->date_update=$datos["date_update"];
        $this->user_create=$datos["user_create"];
        
    }
                    
        
    public function getDatos()
    {                
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    } 
        
    public function listDBUser(Adapter $dbAdapter, $id_usuario){
         $this->dbAdapter=$dbAdapter;
         $query = "SELECT a.id,a.nombre_db,a.nombre,a.foto,a.icono,a.descripcion,a.info,a.orden,
         b.id_perfil,b.nro_session,(select nombre from sis_m_perfil p where p.id=b.id_perfil) as perfil  
         FROM sis_m_db a, sis_m_usudb b WHERE a.id = b.id_db  and a.activo=1 and b.id_usuario=".$id_usuario." 
         order by orden";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();
    }
    
    public function actualizarDb($id, $nombre)
    {
        
        self::cargarCampos(array('nombre'=>'nombre'));
        $array=array
             (
                'nombre'=>$nombre,                             
             );
        
        $this->update($array, array('id' => $id));
    }
    
    public function getDireccion(Adapter $dbAdapter, $nombredb)
    {        
         $this->dbAdapter=$dbAdapter;
         $query = "SELECT direccion FROM ".$nombredb."sis_m_gral";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();
    }
}

