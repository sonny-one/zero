<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class LavanderiaTable extends TableGateway
{
    private $id;
    private $lavadoras;
    private $secadoras;
    private $valor;
    private $horario;
    private $horariofin;
    private $reglas;
    private $estado;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_lavanderia', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
    private function cargarCampos($datos=array())
    {    
        $this->lavadoras=$datos["lavadoras"];
        $this->secadoras=$datos["secadoras"];   
        $this->valor=$datos["valor"];
        $this->horario=$datos["horario"];
        $this->horariofin=$datos["horariofin"];
        $this->reglas=$datos["reglas"];
        $this->estado=$datos["estado"];
                 
    }
                    
    public function getDatos()
    {                
        $datos = $this->select();
        $recorre = $datos->toArray();
        return $recorre;
    } 
            
    public function actualizarLav($id, $lista=array())
    {
        
        self::cargarCampos($lista);
        $array=array
             (
                'lavadoras'=>$this->lavadoras,
                'secadoras'=>$this->secadoras,
                'valor'=>$this->valor,
                'horario'=>$this->horario,
                'horariofin'=>$this->horariofin,
                'reglas'=>$this->reglas,
                'estado'=>$this->estado,
                
                
             );
        
        $this->update($array, array('id' => $id));
    } 
    public function nuevaLav($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'lavadoras'=>$this->lavadoras,
                'secadoras'=>$this->secadoras,
                'valor'=>$this->valor,
                'horario'=>$this->horario,
                'horariofin'=>$this->horariofin,
                'reglas'=>$this->reglas,
                'estado'=>'0',
                
             );
               $this->insert($array);                               
 
    } 
    
}
