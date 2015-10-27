<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class EdificacionTable extends TableGateway
{
    
    private $id;
    private $departamento;
    private $piso;
    private $subterraneo;
    private $est_visita;
    private $torre;
    private $ascensor;
    private $quincho;
    private $salon;
    private $piscina;
    private $gimnasio;
    private $acceso;
    private $lavanderia;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_edificacion', $adapter, $databaseSchema,$selectResultPrototype);
    }
     
         private function cargarCampos($datos=array())
    {    
        $this->departamento=$datos["departamento"];
        $this->piso=$datos["piso"];   
        $this->subterraneo=$datos["subterraneo"];
        $this->est_visita=$datos["est_visita"];
        $this->torre=$datos["torre"];
        $this->ascensor=$datos["ascensor"];
        $this->salon=$datos["salon"];
        $this->quincho=$datos["quincho"];
        $this->piscina=$datos["piscina"];
        $this->gimnasio=$datos["gimnasio"];
        $this->acceso=$datos["acceso"];
        $this->lavanderia=$datos["lavanderia"];
                 
    }
                    
        
    public function getDatos()
    {
        $datos = $this->select();
        $recorre = $datos->toArray();
        return $recorre;
    } 
    
    public function guardarEdificacion($id, $lista=array())
    {
        
        self::cargarCampos($lista);
        $array=array
             (
                'departamento'=>$this->departamento,
                'piso'=>$this->piso,
                'subterraneo'=>$this->subterraneo,
                'est_visita'=>$this->est_visita,
                'salon'=>$this->salon,
                'torre'=>$this->torre,
                'ascensor'=>$this->ascensor,
                'quincho'=>$this->quincho,
                'piscina'=>$this->piscina,
                'gimnasio'=>$this->gimnasio,
                'acceso'=>$this->acceso,
                'lavanderia'=>$this->lavanderia
                
             );
        
        $this->update($array, array('id' => $id));
    } 
    
        public function nuevoEdif($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'departamento'=>$this->departamento,
                'piso'=>$this->piso,
                'subterraneo'=>$this->subterraneo,
                'est_visita'=>$this->est_visita,
                'salon'=>$this->salon,
                'torre'=>$this->torre,
                'ascensor'=>$this->ascensor,
                'quincho'=>$this->quincho,
                'piscina'=>$this->piscina,
                'gimnasio'=>$this->gimnasio,
                'acceso'=>$this->acceso,
                'lavanderia'=>$this->lavanderia,              
             );
               $this->insert($array);
        }
}
