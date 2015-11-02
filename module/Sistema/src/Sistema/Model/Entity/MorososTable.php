<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class MorososTable extends TableGateway
{
    private $id;
    private $id_persona;
    private $monto;
    private $causa;
    private $dias;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_moroso', $adapter, $databaseSchema,$selectResultPrototype);
    }
      private function cargarCampos($datos=array())
    {    
        $this->id_persona=$datos["id_persona"];
        $this->monto=$datos["monto"];
        $this->causa=$datos["causa"];
        $this->meses=$datos["dias"];      
        
    }
    public function getDatos()
    {
        $datos = $this->select();
        $recorre = $datos->toArray();
        return $recorre;
    } 
    public function getTotal(Adapter $dbAdapter){
         $this->dbAdapter=$dbAdapter;
         $query = "SELECT SUM(monto) total FROM sis_w_moroso";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();
    }
    public function editarMoroso($id, $data=array())
    {
                self::cargarCampos($data);
                $array=array
             (
                'id_persona'=>$this->id_persona,
                'monto'=>$this->monto,
                'causa'=>$this->causa,
                'meses'=>$this->meses,            
                
             );
        
                  $this->update($array, array('id' => $id));
        
    }
        public function nuevoMoroso($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_persona'=>$this->id_persona,
                'monto'=>$this->monto,
                'causa'=>$this->causa,
                'meses'=>$this->meses,                
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;  
               
    }
    

        
    
}
