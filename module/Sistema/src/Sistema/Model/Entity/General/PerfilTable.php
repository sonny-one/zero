<?php
namespace Sistema\Model\Entity\General;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class PerfilTable extends TableGateway
{

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_perfil', $adapter, $databaseSchema,$selectResultPrototype);
    }
             
    
     public function getDatosxPerfil($perfil)
    {        
        $datos = $this->select(array('nombre'=>$perfil));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
         public function getIdxPerfil($perfil)
    {        
        $datos = $this->select(array('nombre'=>$perfil));
        $recorre = $datos->toArray();
                      
        return $recorre[0]['id'];
    }
     

    
}