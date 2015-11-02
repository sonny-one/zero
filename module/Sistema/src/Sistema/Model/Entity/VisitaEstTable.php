<?php

namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;



class VisitaEstTable extends TableGateway

{

   private $id_visita;
    private $id_unidad;
    private $id_estacionamiento;
    private $patente;
    private $fecha_ingreso;
    private $aplica_multa;
    private $user_create;
   
    
    public $dbAdapter;
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_est_visita', $adapter, $databaseSchema,$selectResultPrototype);

    }

    private function cargarCampos($datos=array())

    {    
        $this->id_visita=isset($datos["id_visita"])?$datos["id_visita"]:"0";
        $this->id_unidad=isset($datos["id_unidad"])?$datos["id_unidad"]:"0";
        $this->id_estacionamiento=isset($datos["id_estacionamiento"])?$datos["id_estacionamiento"]:"0";
        $this->fecha_ingreso=isset($datos["fecha_ingreso"])?$datos["fecha_ingreso"]:"";
        $this->patente=isset($datos["patente"])?$datos["patente"]:"";
        $this->aplica_multa=isset($datos["aplica_multa"])?$datos["aplica_multa"]:"1";
        $this->user_create=isset($datos["user_create"])?$datos["user_create"]:"0";

    }

    

    public function nuevaVisitaEst($data=array()){
        
        self::cargarCampos($data);
             $array=array
             (
                'id_visita'=>$this->id_visita,
                'id_unidad'=>$this->id_unidad,
                'id_estacionamiento'=>$this->id_estacionamiento,
                'fecha_ingreso'=>$this->fecha_ingreso,
                'patente'=>$this->patente,
                'aplica_multa'=>$this->aplica_multa,
                'user_create'=>$this->user_create,
             );

               $this->insert($array);
               //$id = $this->lastInsertValue;
               return "ok";
        
    }
    
   
    
    public function eliminaEstVisita($id)
    {
        $this->delete(array('id' => $id));
    }
    
    


    

}