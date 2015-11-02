<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class MultaTable extends TableGateway
{

    private $id_unidad;
    private $fecha;
    private $monto;
    private $pagado;
    
    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_multa', $adapter, $databaseSchema,$selectResultPrototype);
    }
    private function cargarCampos($datos=array())

    {    
        $this->id_unidad=$datos["id_unidad"];
        $this->fecha=$datos["fecha"];   
        $this->monto=$datos["monto"];
        $this->pagado=$datos["activo"];
    }

    public function getDatos()

    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();                     

        return $recorre;
    }

    public function pagoMultaTotal(Adapter $dbAdapter,$id_unidad)

    {            
         $this->dbAdapter=$dbAdapter;
         $query = "update sis_w_multa set pagado = 's' where id_unidad =".$id_unidad;
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result;
    } 
    public function getMultaUnidad($id_unidad)
    {        
        $datos = $this->select(array('id_unidad'=>$id_unidad,'pagado'=>'n'));
        $recorre = $datos->toArray();
                      
        return $recorre;
    }

    public function getDatosxPersona($id_persona)
    {    
        $datos = $this->select(array('id_persona'=>$id_persona));
        $recorre = $datos->toArray();                    

        return $recorre;
    }

}