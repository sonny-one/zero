<?php
namespace Sistema\Model\Entity\General;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class UsudbTable extends TableGateway
{ 
    private $id_usuario;
    private $id_db;
    private $id_perfil;
    private $nro_session;
    private $user_create;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_usudb', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())
    {    
        $this->id_usuario=$datos["id_usuario"];
        $this->id_db=$datos["id_db"];
        $this->id_perfil=$datos["id_perfil"];
        $this->user_create=$datos["user_create"];                                                 
    }

    public function nuevoUsudb($data=array())

    {
             self::cargarCampos($data);
             $array=array
             (
                'id_usuario'=>$this->id_usuario,
                'id_db'=>$this->id_db,
                'id_perfil'=>$this->id_perfil,
                'user_create'=>$this->user_create,              
                'nro_session'=>'0'                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id; 

    } 
    
    public function getDatos($id_usuario)
    {
        $datos = $this->select(array('id'=>$id_usuario));
        $recorre = $datos->toArray();
        return $recorre;
    } 
    public function getDatosMail($mail)
    {
        $datos = $this->select(array('correo_1'=>$mail));
        $recorre = $datos->toArray();
        return $recorre;
    } 
}