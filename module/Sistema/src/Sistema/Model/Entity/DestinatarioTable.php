<?php 
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class DestinatarioTable extends TableGateway
{
    private $id_modulo;
    private $nombre;
 
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_destinatario_reclamo', $adapter, $databaseSchema,$selectResultPrototype);
    }
      
       
    public function GetDestinatarioReclamo()
    {
     
        $datos = $this->select();
        $recorre = $datos->toArray();
        $resultado['']="Seleccione Destinatario";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id_modulo']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
        
    }
    
}
