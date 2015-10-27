<?php
namespace Sistema\Model\Entity\General;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class SessionTable extends TableGateway
{
    private $id_usuario;
    private $ip_cliente;
    private $port_cliente;
    private $id_db;
    private $date_start;
    
    
    public $dbAdapter;
   

    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_session', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
     private function cargarCampos($datos=array())
    {
       
        $this->id_usuario=$datos["id_usuario"];
        $this->ip_cliente=$datos["ip_cliente"];
        $this->port_cliente=$datos["port_cliente"];
        $this->id_db=$datos["id_db"];
        $fecha = time();
        $this->date_start=date("Y-m-d H:i:s",$fecha);
        
        
    }
    public function obtenetSesion($id_usuario,$id_db)
    {
            $datos = $this->select(array('id_usuario'=>$id_usuario,'id_db'=>$id_db));
            return $datos->toArray();
    }
    
    public function crearSesion($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_usuario'=>$this->id_usuario,
                'ip_cliente'=>$this->ip_cliente,
                'id_db'=>$this->id_db,
                'port_cliente'=>$this->port_cliente,
                'date_start'=>$this->date_start,
             );
               $this->insert($array);
               return $this->lastInsertValue;
               
        }
        
    public function eliminarSesion($id)
    {
        $this->delete(array('id' => $id));
    }
}