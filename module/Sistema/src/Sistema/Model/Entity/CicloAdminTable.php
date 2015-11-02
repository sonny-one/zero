<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class CicloAdminTable extends TableGateway
{
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_cierre_mes', $adapter, $databaseSchema,$selectResultPrototype);
    }
                  
        
    public function getCiclo()
    {
        $datos = $this->select();
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function updateCierreMes($dia,$hora)
    {
             $array=array
             (
                'dia'=>$dia,
                'hora'=>$hora,
             );
                $this->update($array,array('id'=>'1'));
    }
    
    
       
}
