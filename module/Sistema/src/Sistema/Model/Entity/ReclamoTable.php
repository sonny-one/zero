<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class ReclamoTable extends TableGateway
{
    private $id_usuario;
    private $id_dpto;
    private $id_tipo_asunto;
    private $receptor;
    private $nombre;
    private $estado;
    private $descripcion;
    private $date_start;
    private $date_update;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('us_w_reclamo', $adapter, $databaseSchema,$selectResultPrototype);
    }
     private function cargarCampos($datos=array())
    {
       
        $this->id_usuario=$datos["id_usuario"];
        $this->id_dpto=$datos["id_dpto"];
        $this->id_tipo_asunto=$datos["id_tipo_asunto"];
        $this->nombre=$datos["nombre"];
        $this->receptor=$datos["receptor"];
        $this->estado=$datos["estado"];
        $this->descripcion=$datos["descripcion"];
        $fecha = time();
        $this->date_start=date("Y-m-d H:i:s",$fecha);
        $this->date_update=date("Y-m-d H:i:s",$fecha);
        
        
    }
        public function getReclamo()
    {
            $datos = $this->select();
            return $datos->toArray();
    }
    public function getReclamos(Adapter $dbAdapter,$llave)
    {
        
        $this->dbAdapter=$dbAdapter;
        $query = "SELECT *,(select nombre from ad_s_dpto where id=id_dpto) as dpto ,(select nombre from ad_s_tipo_asunto where id=id_tipo_asunto) as asunto, (date_format(date_start,'%d-%m-%Y')) AS date_corta, substring(descripcion,1,12) as descripcion_corta FROM us_w_reclamo as uwr ";
        
        if($llave>0){
            $query = $query . " WHERE id=".$llave;
        }
        
        $query = $query . " order by id desc";
        
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
        
    }
        
    public function nuevoReclamo($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_usuario'=>$this->id_usuario,
                'id_dpto'=>$this->id_dpto,
                'id_tipo_asunto'=>$this->id_tipo_asunto,
                'nombre'=>$this->nombre,
                'receptor'=>$this->receptor,
                'descripcion'=>$this->descripcion,
                'estado'=>'abierto',
                'date_start'=>$this->date_start,
                'date_update'=>$this->date_update
                
             );
               $this->insert($array);
               
        }
    public function actualizarReclamo($id, $data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_usuario'=>$this->id_usuario,
                'id_dpto'=>$this->id_dpto,
                'id_tipo_asunto'=>$this->id_tipo_asunto,
                'nombre'=>$this->nombre,
                'receptor'=>$this->receptor,
                'descripcion'=>$this->descripcion,
                'estado'=>$this->estado,
                'date_update'=>$this->date_update
                
             );
        
        $this->update($array, array('id' => $id));
    }
    
    public function getEstadistica(Adapter $dbAdapter, $flag)
    {
        
        $this->dbAdapter=$dbAdapter;

        $query =  "SELECT count(*) as total FROM us_w_reclamo WHERE estado='$flag' order by id desc";
              
        
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);		
        $datos = $result->toArray();
        return $datos;
        
    }
    
    public function eliminarReclamo($id)
    {
        $this->delete(array('id' => $id));
    }
    
    
    
}
