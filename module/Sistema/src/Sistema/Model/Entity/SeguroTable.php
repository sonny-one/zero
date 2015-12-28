<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class SeguroTable extends TableGateway
{

    private $id_proveedor;
    private $id_egreso;
    private $poliza;
    private $riesgo;
    private $valor_prima;
    private $cuotas;
    private $vigencia;
    private $vigenciafin;
    private $estado;
    private $detalle;
    private $activo;
    private $url_poliza;


    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_seguro', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())
    {    
        $this->id_proveedor=$datos["id_proveedor"];
        $this->id_egreso=$datos["id_egreso"];
        $this->poliza=$datos["poliza"];
        $this->riesgo=$datos["riesgo"];   
        $this->valor_prima=$datos["valor_prima"];
        $this->cuotas=$datos["cuotas"];
        $this->vigencia=$datos["vigencia"];
        $this->vigenciafin=$datos["vigenciafin"];
        $this->detalle=$datos["detalle"];
        $this->estado=$datos["estado"];           
        $this->activo=$datos["activo"];
        $this->url_poliza=$datos["url_poliza"];            
    }

    public function getDatos()
    {                
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    } 
    public function getDatosid($id)
    {
        $datos = $this->select(array('id'=>$id));   
        return $datos->toArray();
    } 

    public function actualizarSeguro($lista=array())
    {
        self::cargarCampos($lista);
        $array=array 
             (
                'poliza'=>$this->poliza,
                'riesgo'=>$this->riesgo,
                'valor_prima'=>$this->valor_prima,
                'cuotas'=>$this->cuotas,
                'vigencia'=>$this->vigencia,
                'vigenciafin'=>$this->vigenciafin,
                'estado'=>$this->estado,
                'detalle'=>$this->detalle,
                'url_poliza'=>$this->url_poliza,                                                                                  
             );
        $this->update($array, array('id' =>$lista['id']));
    } 

    public function nuevoSeguro($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (                
                'id_proveedor'=>$this->id_proveedor,
                'id_egreso'=>$this->id_egreso,
                'poliza'=>$this->poliza,
                'riesgo'=>$this->riesgo,
                'valor_prima'=>$this->valor_prima,
                'cuotas'=>$this->cuotas,
                'vigencia'=>$this->vigencia,
                'vigenciafin'=>$this->vigenciafin,
                'estado'=>'1',
                'detalle'=>$this->detalle,  
                'url_poliza'=>$this->url_poliza,            
                'activo'=>'1'

             );
               $this->insert($array);
        }

    public function borrarSeguro($id)
    {     
        $array=array('activo'=>'0');
        $this->update($array, array('id' => $id));
    }

    public function estadoSeguro($id,$estado,$detalle)
    {
        self::cargarCampos(array('estado'=>'estado','detalle'=>'detalle'));
        $array=array
             (
                'estado'=>$estado,
                'detalle'=>$detalle,
             );
        $this->update($array, array('id' => $id));
    }
}

