<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

use Sistema\Util\SysFnc;

class NotaMantTable extends TableGateway

{
    private $texto;
     
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
       return parent::__construct('sis_w_nota_mantencion', $adapter, $databaseSchema,$selectResultPrototype);
    }
 
      public function getNotas()
    {
        
        $datos = $this->select(function (Select $select) {
             $select->where->like('activo', '1');
            $select->order('date_start DESC'); //->limit(2);
        });
        $recorre = $datos->toArray();
                      
        return $recorre;
    }
    
    public function nuevaNota($lista)
    {                
        $array=array(
                    'texto'=>$lista['texto'],
                    'user_create'=>$lista['user_create'],
                    'date_update'=>SysFnc::FechaActualYmdHms(),
                    'activo'=>'1',
                     );                                
        $this->insert($array);  
        $id = $this->lastInsertValue;
        
        return $id;                    
    } 
    
    public function eliminaNota($id)
    {
        $array=array('activo'=>'0');        
        $this->update($array,array('id'=>$id));          
                           
    }   
    public function getNotaId($id)
     {
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
                      
        return $recorre;                                     
    }  
    
    public function updateNota($lista)
    {   
        $array=array(
                'texto'=>$lista['texto'],
                'date_update'=>SysFnc::FechaActualYmdHms()
        );        
        $this->update($array,array('id'=>$lista['id'])); 
        
    }
}