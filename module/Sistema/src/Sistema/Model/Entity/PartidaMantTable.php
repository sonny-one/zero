<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class PartidaMantTable extends TableGateway
{    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
       return parent::__construct('sis_w_partida_mantencion', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
    private function cargarCampos($datos=array())

    {    
        $this->ene=$datos["ene"];        
        $this->piso=$datos["piso"];   
        $this->tipo=$datos["tipo"];
        $this->mts=$datos["mts"];
        $this->alicuota=$datos["alicuota"];
        $this->habitaciones=$datos["habitaciones"];
        $this->banos=$datos["banos"];
        $this->estado=$datos["estado"];
        $this->descripcion=$datos["descripcion"];   
        $this->user_create=$datos["user_create"];                        

    }
    
    public function getPartidas()
    {        
        $datos = $this->select(array("activo"=>'1'));
        $recorre = $datos->toArray();
        return $recorre;

    }
    
    public function getPartidaId(Adapter $dbAdapter,$id)
    {
        $this->dbAdapter = $dbAdapter;
        $query = "select * from sis_w_partida_mantencion where id='".$id."' and activo = '1'";
                
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
        
    }
    
    public function getPartidasMes($mes)
    {
        $datos = $this->select(array("$mes"=>'on',"activo"=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
        
    }
    
    public function eliminarPartida($id)
    {        
        $this->update(array("activo"=>'0'),array("id"=>$id));        
    }
    
    
    public function guardarPartida($data)
    {             
             $array=array
             (
                'ene'=>$data['Jan'],
                'feb'=>$data['Feb'],
                'mar'=>$data['Mar'],
                'abr'=>$data['Apr'],
                'may'=>$data['May'],
                'jun'=>$data['Jun'],
                'jul'=>$data['Jul'],
                'ago'=>$data['Aug'],            
                'sep'=>$data['Sep'],
                'oct'=>$data['Oct'],
                'nov'=>$data['Nov'],             
                'dic'=>$data['Dec'],                                  
             );
               $this->update($array,array('id'=>$data['id_pk']));
    }
}