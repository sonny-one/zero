<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class TipoContratoTable extends TableGateway
{
    private $nombre;
    
    public $dbAdapter;
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_tipo_contrato', $adapter, $databaseSchema,$selectResultPrototype);
    }     
        
    public function getTipoContrato()
    {
        $datos = $this->select(array('activo'=>'1',));
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione un Tipo";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 
    
    public function getTipoId($id)
    {
        $datos = $this->select(array('id'=>$id,'activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;          
    } 
    
    public function getTipoNombre($nombre)
    {
        $datos = $this->select(array('nombre'=>$nombre));
        $recorre = $datos->toArray();
        return $recorre;          
    }        
}