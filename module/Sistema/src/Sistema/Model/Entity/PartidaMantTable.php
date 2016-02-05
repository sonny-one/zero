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
    
    public function getPartidaId($id)
    {        
       $datos = $this->select(array("id"=>$id,"activo"=>'1'));
       $recorre = $datos->toArray();
       return $recorre;
        
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
                'Jan'=>$data['Jan'],
                'Feb'=>$data['Feb'],
                'Mar'=>$data['Mar'],
                'Apr'=>$data['Apr'],
                'May'=>$data['May'],
                'Jun'=>$data['Jun'],
                'Jul'=>$data['Jul'],
                'Aug'=>$data['Aug'],            
                'Sep'=>$data['Sep'],
                'Oct'=>$data['Oct'],
                'Nov'=>$data['Nov'],             
                'Dec'=>$data['Dec'],                                  
             );
               $this->update($array,array('id'=>$data['id_pk']));
    }
}