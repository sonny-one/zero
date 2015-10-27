<?php

namespace Sistema\Model\Entity\General;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;



class UsuarioTable extends TableGateway

{
    private $usuario;
    private $clave;
    private $id_persona;    
    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {

        return parent::__construct('sis_m_usuario', $adapter, $databaseSchema,$selectResultPrototype);

    }
    private function cargarCampos($datos=array())
    {    
        $this->usuario=$datos["usuario"];
        $this->clave=$datos["password"];
        $this->id_persona=$datos["id_persona"];                                 
    }

    public function getUsuario($usuario,$password)

    {

        $datos = $this->select(array('usuario'=>$usuario,'clave'=>$password));

        $recorre = $datos->toArray();

        return $recorre;

    } 
    public function getNombreUsuario($usuario)

    {

        $datos = $this->select(array('usuario'=>$usuario));

        $recorre = $datos->toArray();

        return $recorre;

    }
    public function nuevoUsuario($data=array())

    {
             self::cargarCampos($data);
             $array=array
             (
                'usuario'=>$this->usuario,
                'clave'=>$this->clave,
                'id_persona'=>$this->id_persona,                           
                'activo'=>'1'                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id; 

    } 
   public function cambioClave($id, $clave)
    {
        
        self::cargarCampos(array('clave'=>'clave'));
        $array=array
             (
                'clave'=>$clave,
                
             );
        
        $this->update($array, array('id_persona' => $id));
    }
    public function cambioClaveuser($user, $clave)
    {
        
        self::cargarCampos(array('clave'=>'clave'));
        $array=array
             (
                'clave'=>$clave,
                
             );
        
        $this->update($array, array('usuario' => $user));
    }
 

    public function getModulo(Adapter $dbAdapter,$perfil)
    {

        $this->dbAdapter=$dbAdapter;
        $query = "SELECT nombre,icon,url FROM sis_m_acceso a, sis_m_modulo m WHERE a.id_modulo=m.id and id_perfil=$perfil and m.activo=1";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();


        
    }
    
    public function existeUsuario(Adapter $dbAdapter,$usuario)

    {
        $this->dbAdapter=$dbAdapter;
        $query = "SELECT usuario FROM sis_m_usuario WHERE usuario like '$usuario%'";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();

    }

}