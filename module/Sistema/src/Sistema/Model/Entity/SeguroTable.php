<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class SeguroTable extends TableGateway
{
    private $id;
    private $poliza;
    private $riesgo;
    private $valor_prima;
    private $cuotas;
    private $vigencia;
    private $vigenciafin;
    private $estado;
    private $detalle;
    private $activo;

    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_seguro', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
         private function cargarCampos($datos=array())
    {    
        $this->poliza=$datos["poliza"];
        $this->riesgo=$datos["riesgo"];   
        $this->valor_prima=$datos["valor_prima"];
        $this->cuotas=$datos["cuotas"];
        $this->vigencia=$datos["vigencia"];
        $this->vigenciafin=$datos["vigenciafin"];
        $this->detalle=$datos["detalle"];
        $this->estado=$datos["estado"];           
        $this->activo=$datos["activo"];        
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
            
    public function actualizarSeguro($id, $lista=array())
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
                
             );
        
        $this->update($array, array('id' => $id));
    } 
    public function nuevoSeguro($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'poliza'=>$this->poliza,
                'riesgo'=>$this->riesgo,
                'valor_prima'=>$this->valor_prima,
                'cuotas'=>$this->cuotas,
                'vigencia'=>$this->vigencia,
                'vigenciafin'=>$this->vigenciafin,
                'estado'=>'0',
                'detalle'=>$this->detalle,              
                'activo'=>'1'
                
             );
               $this->insert($array);
               
        }
    public function borrarSeguro($id)
    {
        
        self::cargarCampos(array('activo'=>'activo'));
        $array=array
             (
                'activo'=>'0',
                
             );
        
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
