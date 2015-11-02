<?php

namespace Sistema\Model\Entity;



use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Adapter\Adapter;

use Zend\Db\Sql\Sql;

use Zend\Db\ResultSet\ResultSet;



class MotivoVisitaTable extends TableGateway

{

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_m_motivo', $adapter, $databaseSchema,$selectResultPrototype);
    }



    

    public function getDatosActivos()

    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 

    

}