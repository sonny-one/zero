<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class SalonTable extends TableGateway
{
    private $id;
    private $nombre;
    private $capacidad;
    private $valor;
    private $garantia;
    private $horario1;
    private $horario1fin;
    private $horario2;
    private $horario2fin;
    private $estado;
    private $reglas;
    private $detalle;
    private $activo;

    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_salon', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
         private function cargarCampos($datos=array())
    {    
        $this->nombre=$datos["nombre"];
        $this->capacidad=$datos["capacidad"];   
        $this->valor=$datos["valor"];
        $this->garantia=$datos["garantia"];
        $this->horario1=$datos["horario1"];
        $this->horario1fin=$datos["horario1fin"];
        $this->horario2=$datos["horario2"];
        $this->horario2fin=$datos["horario2fin"];
        $this->estado=$datos["estado"];   
        $this->reglas=$datos["reglas"];
        $this->detalle=$datos["detalle"];
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
            
    public function actualizarSalon($id, $lista=array())
    {
        
        self::cargarCampos($lista);
        $array=array
             (
                'nombre'=>$this->nombre,
                'capacidad'=>$this->capacidad,
                'valor'=>$this->valor,
                'garantia'=>$this->garantia,
                'horario1'=>$this->horario1,
                'horario1fin'=>$this->horario1fin,
                'horario2'=>$this->horario2,
                'horario2fin'=>$this->horario2fin,
                'estado'=>$this->estado,
                'reglas'=>$this->reglas,
                'detalle'=>$this->detalle,                        
                
             );
        
        $this->update($array, array('id' => $id));
    } 
    public function nuevoSalon($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'nombre'=>$this->nombre,
                'capacidad'=>$this->capacidad,
                'valor'=>$this->valor,
                'garantia'=>$this->garantia,
                'horario1'=>$this->horario1,
                'horario1fin'=>$this->horario1fin,
                'horario2'=>$this->horario2,
                'horario2fin'=>$this->horario2fin,
                'estado'=>'0',
                'reglas'=>$this->reglas,
                'activo'=>'1'
                
             );
               $this->insert($array);
               
        }
    public function borrarSalon($id)
    {
        
        self::cargarCampos(array('activo'=>'activo'));
        $array=array
             (
                'activo'=>'0',
                
             );
        
        $this->update($array, array('id' => $id));
    }
    public function estadoSalon($id,$estado,$detalle)
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
