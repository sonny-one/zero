<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;



class ComunidadTable extends TableGateway

{

    private $id_persona;
    private $telefono_admin;
    private $telefono_cons;
    private $emailcom;
    private $emailgc;
    private $web;
    private $activo;

    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_m_comunidad', $adapter, $databaseSchema,$selectResultPrototype);
    }

    

    private function cargarCampos($datos=array())

    {    

        $this->id_persona=$datos["id_persona"]; 
        $this->telefono_admin=$datos["telefono"]; 
        $this->telefono_cons=$datos["telefono2"];
        $this->emailcom=$datos["emailcom"];
        $this->emailgc=$datos["emailgc"];
        $this->web=$datos["web"];                      

    }     

    public function getDatos()

    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    } 
    
     public function getComunidad($id)

    {
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
        return $recorre;
    } 

    public function guardarComunidad($id, $data=array())
    {
        
        self::cargarCampos($data);
        $array=array        
             (
                'id_persona'=>$this->id_persona,
                'telefono_admin'=>$this->telefono_admin,
                'telefono_cons'=>$this->telefono_cons,
                'emailcom'=>$this->emailcom,
                'emailgc'=>$this->emailgc,
                'web'=>$this->web,
                                
                                                
             );
        
            $this->update($array, array('id' => $id));
    }
    
        public function nuevaComunidad($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_persona'=>$this->id_persona,
                'telefono_admin'=>$this->telefono_admin,
                'telefono_cons'=>$this->telefono_cons,
                'emailcom'=>$this->emailcom,
                'emailgc'=>$this->emailgc,
                'web'=>$this->web,
                'activo'=>'1'
                
             );
               $this->insert($array);
               
        } 
}