<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class MensajeModuloTable extends TableGateway
{     
    private $id_perdet;
    private $id_modulo_o;
    private $id_modulo_d;
    private $id_msj_rspta;
    private $asunto;
    private $texto;
    private $adjunto;
    private $estado;
    private $date_update;
    private $activo;
    
    
    public $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_msj_modulo', $adapter, $databaseSchema,$selectResultPrototype);
    }

    private function cargarCampos($datos=array())
    {    
	$this->id_perdet=$datos["id_perdet"];
        $this->id_modulo_o=$datos["id_modulo_o"];  
        $this->id_modulo_d=$datos["id_modulo_d"];   
        $this->id_msj_rspta=isset($datos["id_msj_rspta"])?$datos["id_msj_rspta"]:null;
        $this->asunto=$datos["asunto"];
        $this->texto=$datos["texto"];
        $this->adjunto=isset($datos["adjunto"])?$datos["adjunto"]:null;
        $this->estado=$datos["estado"];
        $this->date_update=isset($datos["date_update"])?$datos["date_update"]:null;
        $this->activo=isset($datos["activo"])?$datos["activo"]:null;
    }   
    
        public function nuevoMsjModulo($datos)
    {
             self::cargarCampos($datos);
             $array=array
             (
                'id_perdet'=>$this->id_perdet,
                'id_modulo_o'=>$this->id_modulo_o,
                 'id_modulo_d'=>$this->id_modulo_d,
                'id_msj_rspta'=>$this->id_msj_rspta,
                'asunto'=>$this->asunto,
                 'texto'=>$this->texto,
                 'adjunto'=>$this->adjunto,
                 'estado'=>$this->estado,
                 'date_update'=>$this->date_update,
                 'activo'=>$this->activo,
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;                              
    }
    
    
    
    public function getMsjModuloRecibido(Adapter $dbAdapter,$id_modulo)
    {
        
         $this->dbAdapter=$dbAdapter;
        $query = "SELECT id,adjunto,asunto,estado,date_start,id_modulo_o,
            (select nombre from thouseap_general.sis_m_modulo n where n.id=m.id_modulo_o) as de,
            (select concat(nombre,' ',apellido,' ',apellido_2) from 
                thouseap_general.sis_m_persona p where p.id=m.id_perdet) as nombres
                  FROM sis_w_msj_modulo m where m.id_modulo_d=".$id_modulo." order by date_start desc";
        
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
        
        
    }
 public function getMsjModuloEnviado(Adapter $dbAdapter,$id_modulo)
    {
        
         $this->dbAdapter=$dbAdapter;
        $query = "SELECT id,adjunto,asunto,estado,date_start,
            (select nombre from thouseap_general.sis_m_modulo n where n.id=m.id_modulo_d) as para,
            (select concat(nombre,' ',apellido,' ',apellido_2) from 
                thouseap_general.sis_m_persona p where p.id=m.id_perdet) as nombres
                  FROM sis_w_msj_modulo m where m.id_modulo_o=".$id_modulo." order by date_start desc";
        
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
        
        
    }    

        public function getMsjModuloDetalle($id_msj)
    {
        $datos = $this->select(array('id'=>$id_msj,'activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function actualizaEstado($id_msj,$estado)
    {
        $array=array('estado'=>$estado);
        $this->update($array, array('id' => $id_msj));
    }

    

}