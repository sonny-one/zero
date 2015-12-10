<?php

namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;



class CircularTable extends TableGateway

{

    private $descripcion_file;
    private $nombre_file;
    private $tamanio_file;
    private $destino;
    private $estado;
    private $activo;
    private $date_update;
    private $user_create;
    private $user_update;

    public $dbAdapter;
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_circular', $adapter, $databaseSchema,$selectResultPrototype);

    }

    private function cargarCampos($datos=array())

    {    
        $this->descripcion_file=isset($datos["descripcion_file"])?$datos["descripcion_file"]:"";
        $this->nombre_file=isset($datos["nombre_file"])?$datos["nombre_file"]:"";
        $this->tamanio_file=isset($datos["tamanio_file"])?$datos["tamanio_file"]:"0";
        $this->destino=isset($datos["destino"])?$datos["destino"]:"";
        $this->estado=isset($datos["estado"])?$datos["estado"]:"";
        $this->activo=isset($datos["activo"])?$datos["activo"]:null;
        $this->user_create=isset($datos["user_create"])?$datos["user_create"]:"0";
        $this->user_update=isset($datos["user_update"])?$datos["user_update"]:"0";
        $this->date_update=isset($datos["date_update"])?$datos["date_update"]:null;

    }

    

    public function nuevoCircular($data=array()){
        
        self::cargarCampos($data);
             $array=array
             (
                'descripcion_file'=>$this->descripcion_file,
                'nombre_file'=>$this->nombre_file,
                'tamanio_file'=>$this->tamanio_file,
                'destino'=>$this->destino,
                'estado'=>$this->estado,
                'activo'=>$this->activo,
                'user_create'=>$this->user_create,
                'user_update'=>$this->user_update,
                'date_update'=>$this->date_update,
             );

               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        
    }
    
    
    public function getListaCirculares (Adapter $dbAdapter){
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT *  FROM sis_w_circular  where activo=1 order by date_start desc limit 25 ";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
        
    }
    public function getCircularByName(Adapter $dbAdapter,$nombre){
        $this->dbAdapter = $dbAdapter;
        $query = "SELECT *  FROM sis_w_circular  where activo=1 and upper(nombre_file)=upper('".$nombre."') ";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
    }
    public function getCircularByDatos($myDatos){
        $datos = $this->select($myDatos);
        return $datos->toArray();        
    }
    
     public function actualizarCircular($data=array())
    {
         
             $array=array
             (
                'estado'=>$data['estado'],
                'user_update'=>$data['user_update'],
                'date_update'=>$data['date_update']
                
             );
        
        $this->update($array, array('id' => $data['id']));
    }
    
    public function getListadoCorreoActivos(Adapter $dbAdapter){
        
        $this->dbAdapter = $dbAdapter;
        $query = "select concat(nombre,' ',apellido,' ',apellido_2) as nombres,correo 
                  from thouseap_general.sis_m_persona where correo is not null and correo <> ''
                  and id in (select distinct(p.id_persona) from sis_w_perdet p where p.activo = 1) ";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
        
    }

    

}