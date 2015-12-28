<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class TipoServicioTable extends TableGateway
{
    
    private $nombre;
    private $categoria;
   
    public $dbAdapter;
 
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_servicio', $adapter, $databaseSchema,$selectResultPrototype);
    }
 
    public function getComboTipo(Adapter $dbAdapter){

         $this->dbAdapter=$dbAdapter;
         $query = "select distinct(categoria), id from sis_m_servicio group by categoria order by categoria desc";
         $datos=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         $recorre = $datos->toArray();
         $resultado["0"]="Seleccione una Categoria";
            for($i=0;$i<count($recorre);$i++)
              {
                $resultado[$recorre[$i]['id']] = $recorre[$i]['categoria']; 
              }
         return $resultado;
    }
    
    public function getComboAseguradora(Adapter $dbAdapter){

         $this->dbAdapter=$dbAdapter;
         $query = "select distinct(categoria), id from sis_m_servicio where nombre='Aseguradora' group by categoria order by categoria desc";
         $datos=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         $recorre = $datos->toArray();
            for($i=0;$i<count($recorre);$i++)
              {
                $resultado[$recorre[$i]['id']] = $recorre[$i]['categoria']; 
              }
         return $resultado;
    }
    public function getComboServAseguradora(Adapter $dbAdapter){

         $this->dbAdapter=$dbAdapter;
         $query = "select distinct(nombre), id from sis_m_servicio where nombre='Aseguradora' group by nombre order by nombre desc";
         $datos=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         $recorre = $datos->toArray();
            for($i=0;$i<count($recorre);$i++)
              {
                $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
              }
         return $resultado;
    }
    
    
    public function getComboServicio($categoria)
    {
        $datos = $this->select(array('categoria'=>$categoria));
        $recorre = $datos->toArray();
        $resultado["0"]="Seleccione un Servicio o Producto";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    }
    
    public function getServicioId($id)
    {
        
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function getServicioNombre($nombre)
    {
        
        $datos = $this->select(array('nombre'=>$nombre));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
   
    
}