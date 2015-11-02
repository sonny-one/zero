<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class PrevisionTable extends TableGateway
{
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_prevision', $adapter, $databaseSchema,$selectResultPrototype);
    }
 
    public function getDatos()
    {
        $datos = $this->select();
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione prevision";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    }
    
}