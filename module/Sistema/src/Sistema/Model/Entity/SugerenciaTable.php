<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class SugerenciaTable extends TableGateway
{
    private $id_usuario;
    private $id_dpto;
    private $id_tipo_asunto;
    private $nombre;
    private $receptor;
    private $descripcion;
    private $date_start;
    private $date_update;
    private $descripcion_file;
    private $nombre_file;
    
    public $dbAdapter;
   

    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('cj_w_sugerencia', $adapter, $databaseSchema,$selectResultPrototype);
    }
    
     private function cargarCampos($datos=array())
    {
       
        $this->id_usuario=$datos["id_usuario"];
        $this->id_dpto=$datos["id_dpto"];
        $this->id_tipo_asunto=$datos["id_tipo_asunto"];
        $this->nombre=$datos["nombre"];
        $this->receptor=$datos["receptor"];
        $this->descripcion=$datos["descripcion"];
        $fecha = time();
        $this->date_start=date("Y-m-d H:i:s",$fecha);
        $this->date_update=date("Y-m-d H:i:s",$fecha);
        $this->descripcion_file=$datos['descripcionfile'];
        $this->nombre_file=$datos['nombrefile'];
        
        
        
    }
    public function getSugerencia()
    {
            $datos = $this->select();
            return $datos->toArray();
    }
    
    public function getSugerencias(Adapter $dbAdapter,$llave)
    {
        
        $this->dbAdapter=$dbAdapter;
        $query = "SELECT *,(select nombre from sis_m_unidad where id=id_dpto) as dpto ,(select nombre from ad_s_tipo_asunto where id=id_tipo_asunto) as asunto, substring(descripcion,1,12) as descripcion_corta FROM cj_w_sugerencia  ";
        
        if($llave>0){
            $query = $query . " WHERE id=".$llave;
        }
        
        $query = $query . " order by id desc";
        
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
        
    }
    
    public function nuevaSugerencia($data=array())
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
                'date_start'=>$this->date_start,
                'date_update'=>$this->date_update,
                'descripcion_file'=>$this->descripcion_file,
                'nombre_file'=>$this->nombre_file,
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
               
        }
        
    public function actualizarSugerencia($id, $data=array())
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
                'date_update'=>$this->date_update
                
             );
        
        $this->update($array, array('id_usuario' => '1'));
    }

    public function eliminarSugerencia($id)
    {
        $this->delete(array('id' => $id));
    }
}