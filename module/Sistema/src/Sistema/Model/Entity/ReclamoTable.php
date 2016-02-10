<?php 
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class ReclamoTable extends TableGateway
{
    private $ReclamoSugerencia;
    private $id_usuario;
    private $id_unidad;
    private $id_reseptor;
    private $id_asunto;
    private $mensaje;
    private $titulo;
    private $id_estado;
    private $cant_votos_pos;
    private $cant_votos_neg;
     
    private $fecha;
    private $date_update;
    
    public $dbAdapter;
    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_reclamo', $adapter, $databaseSchema,$selectResultPrototype);
    }
     private function cargarCampos($datos=array())
    {
         
         
        $this->ReclamoSugerencia=$datos["ReclamoSugerencia"];
        $this->id_usuario=$datos["id_usuario"];
        $this->id_unidad=$datos["id_unidad"];
        $this->id_reseptor=$datos["id_reseptor"];
        $this->id_asunto=$datos["id_asunto"];
        $this->mensaje=$datos["mensaje"];
        $this->titulo=$datos["titulo"];
        $fechas = time();
        $this->fecha=date("Y-m-d H:i:s",$fechas);
        $this->date_update=date("Y-m-d H:i:s",$fechas);
      
        
    }
    
     public function getReclamo(Adapter $dbAdapter)
    {
        
$this->dbAdapter=$dbAdapter;
$query="
select 
r.id,
r.id_unidad,
r.id_asunto,
r.titulo,
a.nombre as asunto,
r.mensaje,
ifnull(c.cant_votos_pos,0) as cant_votos_pos,
ifnull(c.cant_votos_neg,0) as cant_votos_neg,
e.nombre as estado
FROM sis_w_reclamo r 
inner join sis_m_asunto_reclamo a on a.id=r.id_asunto 
inner join sis_m_estado_reclamo e on e.id=r.id_estado
left join (select id_reclamo,sum(cant_votos_pos) as cant_votos_pos , SUM(cant_votos_neg) as cant_votos_neg from sis_w_contmegusta group by id_reclamo) c on c.id_reclamo=r.id
order by id DESC
"; 
        
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
        
    } 
 

            
   
    public function getCantReclamo()
    {
         
            $datos = $this->select();
            return $datos->count();
    }
  public function getReclamos(Adapter $dbAdapter)
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
      if ($data['mensaje']!='') {
          
    
            self::cargarCampos($data);
             $array=array
             (
               'ReclamoSugerencia'=>$this->ReclamoSugerencia,
               'id_usuario'=>$this->id_usuario,
               'titulo'=>$this->titulo,
                'id_unidad'=>$this->id_unidad,
               'id_reseptor'=>$this->id_reseptor,
               'id_asunto'=>$this->id_asunto,
               'mensaje'=>$this->mensaje,
               'id_estado'=>1,
               'fecha'=>$this->fecha,
               'cant_votos_pos'=>0,
               'cant_votos_neg'=>0,
             // 'date_update'=>$this->date_update
               
             );
             
            
            $this->insert($array);
         }

        }
  public function actualizarReclamo($id, $data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'id_usuario'=>$this->id_usuario,
                'id_dpto'=>$this->id_dpto,
                'id_tipo_asunto'=>$this->asunto,
                'nombre'=>$this->nombre,
                'receptor'=>$this->receptor,
                'descripcion'=>$this->descripcion,
                'estado'=>$this->estado,
                'date_update'=>$this->date_update
                
             );
        
        $this->update($array, array('id' => $id));
    }
    
    public function megustaReclamo(Adapter $dbAdapter, $id,$id_usuario)
    {             
        $this->dbAdapter=$dbAdapter;

             $query =  "INSERT INTO sis_w_contmegusta 
                set id_reclamo=$id, 
		id_usuario=$id_usuario, 
                cant_votos_pos=1,
                cant_votos_neg=0 
                ON DUPLICATE KEY UPDATE id_reclamo=$id, id_usuario=$id_usuario,
                cant_votos_pos =1,cant_votos_neg=0;";              
                $this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);	
        

    }
       public function nomegustaReclamo(Adapter $dbAdapter, $id,$id_usuario)
    {             
        $this->dbAdapter=$dbAdapter;

          $query =  "INSERT INTO sis_w_contmegusta 
                set id_reclamo=$id, 
		id_usuario=$id_usuario, 
                cant_votos_pos=0,
                cant_votos_neg=1 
                ON DUPLICATE KEY UPDATE id_reclamo=$id, id_usuario=$id_usuario,
                cant_votos_pos =0,cant_votos_neg=1;";              
        
        $this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);		

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
