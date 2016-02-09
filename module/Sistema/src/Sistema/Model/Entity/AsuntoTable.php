<?php 
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class AsuntoTable extends TableGateway
{
    private $id;
    private $nombre;
 
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_asunto_reclamo', $adapter, $databaseSchema,$selectResultPrototype);
    }
      
       
    public function GetAsuntoReclamo()
    {
     
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        $resultado['']="Seleccione Asunto";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
        
    }
    
}
