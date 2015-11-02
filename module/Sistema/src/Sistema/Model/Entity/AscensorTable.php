<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class AscensorTable extends TableGateway
{
    private $id;
    private $fabricante;
    private $modelo;
    private $anio;
    private $capacidad;
    private $activo;
    private $estado;
    private $detalle;

    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_ascensor', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
         private function cargarCampos($datos=array())
    {    
        $this->fabricante=$datos["fabricante"];
        $this->modelo=$datos["modelo"];   
        $this->anio=$datos["anio"];
        $this->capacidad=$datos["capacidad"];
        $this->estado=$datos["estado"];
        $this->detalle=$datos["detalle"];
                 
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
            
    public function actualizarAscensor($id, $lista=array())
    {
        
        self::cargarCampos($lista);
        $array=array
             (
                'fabricante'=>$this->fabricante,
                'modelo'=>$this->modelo,
                'anio'=>$this->anio,
                'capacidad'=>$this->capacidad,
                'estado'=>$this->estado,
                'detalle'=>$this->detalle,
                
             );
        
        $this->update($array, array('id' => $id));
    } 
    public function nuevoAscensor($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'fabricante'=>$this->fabricante,
                'modelo'=>$this->modelo,
                'anio'=>$this->anio,
                'capacidad'=>$this->capacidad,
                'activo'=>'1'
                
             );
               $this->insert($array);
               
        }
    public function borrarAscensor($id)
    {
        
        self::cargarCampos(array('activo'=>'activo'));
        $array=array
             (
                'activo'=>'0',
                
             );
        
        $this->update($array, array('id' => $id));
    }
    
    public function estadoAscensor($id,$estado,$detalle)
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
