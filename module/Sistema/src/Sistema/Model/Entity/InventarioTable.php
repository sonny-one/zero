<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class InventarioTable extends TableGateway
{     
    private $nombre;
    private $id_fondo;
    private $valor;
    private $cantidad;
    private $area_responsable;
    private $responsable;
    private $estado;
    private $factura;
    private $fecha;
    private $marca;
    private $modelo;
    private $nmro_serie; 
    private $ubicacion;
    private $observacion;

    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_inventario', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())

    {    
		$this->nombre=$datos["nombre"];
        $this->id_fondo=$datos["id_fondo"];   
        $this->valor=$datos["valor"];
        $this->cantidad=$datos["cantidad"];
        $this->area_responsable=$datos["area_responsable"];
        $this->responsable=$datos["responsable"];        
        $this->estado=$datos["estado"];
        $this->factura=$datos["factura"];
        $this->fecha=$datos["fecha"];           
        $this->marca=$datos["marca"];
        $this->modelo=$datos["modelo"];
		$this->nmro_serie=$datos["nmro_serie"];
        $this->ubicacion=$datos["ubicacion"];
        $this->observacion=$datos["observacion"];
    }   
    
        public function nuevoActivo($datos)
    {
             self::cargarCampos($datos);
             $array=array
             (
                'nombre'=>$this->nombre,
                'id_fondo'=>$this->id_fondo,
                'valor'=>$this->valor,
                'cantidad'=>$this->cantidad,
                'area_responsable'=>$this->area_responsable,
                'responsable'=>$this->responsable,
                'estado'=>$this->estado,
                'factura'=>$this->factura,
                'fecha'=>$this->fecha,
                'marca'=>$this->marca,
                'modelo'=>$this->modelo,
                'nmro_serie'=>$this->nmro_serie,
                'ubicacion'=>$this->ubicacion,
                'observacion'=>$this->observacion,
                'activo'=>'1'
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;                              
    }
    
    public function editarActivo($id,$data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'nombre'=>$this->nombre,
                'id_fondo'=>$this->id_fondo,
                'valor'=>$this->valor,
                'cantidad'=>$this->cantidad,
                'area_responsable'=>$this->area_responsable,
                'responsable'=>$this->responsable,
                'estado'=>$this->estado,
                'factura'=>$this->factura,
                'fecha'=>$this->fecha,
                'marca'=>$this->marca,
                'modelo'=>$this->modelo,
                'nmro_serie'=>$this->nmro_serie,
                'ubicacion'=>$this->ubicacion,
                'observacion'=>$this->observacion,
                'date_update'=>date('Y-m-d h:m:s'),
             );
               $this->update($array,array('id'=>$id));                  
    }
    
    public function getDatos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    
    public function getActivoId($id)
    {
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
        return $recorre;          
    }

    public function getDatosidPersona($id)

    {

        $datos = $this->select(array('id_persona'=>$id, 'activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    

}