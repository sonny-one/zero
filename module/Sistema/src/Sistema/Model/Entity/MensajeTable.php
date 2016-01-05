<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class MensajeTable extends TableGateway
{     
    private $id_perdet;
    private $destino;
    private $asunto;
    private $texto;
    private $date_update;


    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_mensaje', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())
    {    
		$this->id_perdet=$datos["id_perdet"];
        $this->destino=$datos["destino"];   
        $this->asunto=$datos["asunto"];
        $this->texto=$datos["texto"];
    }   
    
        public function nuevoMensaje($datos)
    {
             self::cargarCampos($datos);
             $array=array
             (
                'id_perdet'=>$this->id_perdet,
                'destino'=>$this->destino,
                'asunto'=>$this->asunto,
                'texto'=>$this->texto,                                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;                              
    }
    
    public function editarMensaje($id,$data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'asunto'=>$this->asunto,
                'texto'=>$this->texto,   
             );
               $this->update($array,array('id'=>$id));                  
    }
    
    public function getMensajesPersona($id_perdet)
    {
        $datos = $this->select(array('id_perdet'=>$id_perdet,'activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    
    

}