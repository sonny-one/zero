<?php

namespace Sistema\Model\Entity\General;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class ModuloTable extends TableGateway

{ 
    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_modulo', $adapter, $databaseSchema,$selectResultPrototype);
    }

    public function getModuloActivo()

    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    } 

}