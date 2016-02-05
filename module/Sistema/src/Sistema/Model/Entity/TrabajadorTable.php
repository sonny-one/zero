<?php
namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class TrabajadorTable extends TableGateway
{     
    private $id_persona;
    private $fecha_contrato;
    private $tipo_contrato;
    private $cargo;
    private $afp;
    private $ccaf;
    private $cargas;
    private $prevision;
    private $valor_prevision;
    private $forma_pago;
    private $banco;
    private $cta_corriente;    

    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_trabajador', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())

    {    
		$this->id_persona=$datos["id_persona"];
        $this->fecha_contrato=$datos["fecha_contrato"];   
        $this->tipo_contrato=$datos["tipo_contrato"];
        $this->cargo=$datos["cargo"];
        $this->afp=$datos["afp"];
        $this->ccaf=$datos["ccaf"];
        $this->cargas=$datos["cargas"];        
        $this->prevision=$datos["prevision"];
        $this->valor_prevision=$datos["valor_prevision"];
        $this->forma_pago=$datos["forma_pago"];           
        $this->banco=$datos["banco"];
		$this->cta_corriente=$datos["cta_corriente"];
    }    

    public function getDatosFull(Adapter $dbAdapter)
    {
         $this->dbAdapter=$dbAdapter;
         $query = "SELECT * FROM sis_w_trabajador w, thouseap_general.sis_m_persona p where w.id_persona=p.id and w.activo = '1'";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();
    } 
        
    public function getTrabajadores(Adapter $dbAdapter)
     {   
         $this->dbAdapter=$dbAdapter;
         $query = "SELECT 
                    t.id as id,
                    CONCAT(p.nombre,' ',p.apellido)as nombre,
                    t.cargo as cargo,
                    t.id_tipo_contrato as id_tipo_contrato
                  FROM thouseap_general.sis_m_persona as p, sis_w_trabajador as t, sis_w_egreso_trabajador as et
                  WHERE t.id_persona = p.id
                  group by t.id_persona";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();
    } 
    
     public function getDatosFullConserje(Adapter $dbAdapter)
     {   
         $this->dbAdapter=$dbAdapter;
         $query = "SELECT * FROM sis_w_trabajador w, thouseap_general.sis_m_persona p where w.id_persona=p.id and w.activo = '1' and w.cargo in ('Conserje','Mayordomo')";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();
    }    

    public function getDatosMail($mail)
    {
        $datos = $this->select(array('correo_1'=>$mail));
        $recorre = $datos->toArray();
        return $recorre;
    }

    public function getDatosidPersona($id)
    {
        $datos = $this->select(array('id_persona'=>$id, 'activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function getComboTrabajadores(Adapter $dbAdapter)
    {
        $this->dbAdapter=$dbAdapter;
        $query ="SELECT w.id as id_trabajador, CONCAT(p.nombre,' ',p.apellido,' (',w.cargo,')') as nombre 
                FROM sis_w_trabajador w, thouseap_general.sis_m_persona p 
                WHERE w.id_persona=p.id
                AND w.activo = '1'";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        $recorre = $result->toArray();
        $resultado["0"]="Selecciona un Trabajador";
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id_trabajador']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    }
    
    public function nuevoTrabajador($datos)
    {
             self::cargarCampos($datos);
             $array=array
             (
                'id_persona'=>$this->id_persona,
                'fecha_contrato'=>$this->fecha_contrato,
                'cargo'=>$this->cargo,
                'activo'=>'1'
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;                              
        }
}