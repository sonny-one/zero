<?php

namespace Sistema\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;



class RsvQuinchoTable extends TableGateway

{

    private $id_uth;
    private $id_unidad;
    private $fecha_uso;              	
    private $estado;                	
    private $pago_reserva;           	
    private $medio_garantia;        	
    private $img_trasaccion;         	
    private $tiempo_reserva;         	
    private $monto_multa;            	
    private $motivo_multa;           	
    private $estado_entrega;         	
    private $observacion_entrega;    	
    private $estado_recibido;        	
    private $observacion_recibido;   	
    private $observacion_cancelacion;
    private $condicion;	
    private $activo;                 	
    private $date_update;            	
    private $user_create;            	
    private $user_update;            	
    

   
    
    public $dbAdapter;
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {
        return parent::__construct('sis_w_rsv_quincho', $adapter, $databaseSchema,$selectResultPrototype);

    }

    private function cargarCampos($datos=array())

    {    
        $this->id_uth=isset($datos["id_uth"])?$datos["id_uth"]:null;
        $this->id_unidad=isset($datos["id_unidad"])?$datos["id_unidad"]:null;
        $this->fecha_uso=isset($datos["fecha_uso"])?$datos["fecha_uso"]:null;              	
        $this->estado=isset($datos["estado"])?$datos["estado"]:null;                	
        $this->pago_reserva=isset($datos["pago_reserva"])?$datos["pago_reserva"]:0;           	
        $this->medio_garantia=isset($datos["medio_garantia"])?$datos["medio_garantia"]:null;        	
        $this->img_trasaccion=isset($datos["img_trasaccion"])?$datos["img_trasaccion"]:null;         	
        $this->tiempo_reserva=isset($datos["tiempo_reserva"])?$datos["tiempo_reserva"]:null;         	
        $this->monto_multa=isset($datos["monto_multa"])?$datos["monto_multa"]:null;            	
        $this->motivo_multa=isset($datos["motivo_multa"])?$datos["motivo_multa"]:null;           	
        $this->estado_entrega=isset($datos["estado_entrega"])?$datos["estado_entrega"]:"";         	
        $this->observacion_entrega=isset($datos["observacion_entrega"])?$datos["observacion_entrega"]:null;    	
        $this->estado_recibido=isset($datos["estado_recibido"])?$datos["estado_recibido"]:null;        	
        $this->observacion_recibido=isset($datos["observacion_recibido"])?$datos["observacion_recibido"]:null;   	
        $this->observacion_cancelacion=isset($datos["observacion_cancelacion"])?$datos["observacion_cancelacion"]:null;	
        $this->activo=isset($datos["activo"])?$datos["activo"]:1; 
        $this->condicion=isset($datos["condicion"])?$datos["condicion"]:"";                	
        $this->date_update=isset($datos["date_update"])?$datos["date_update"]:null;            	
        $this->user_create=isset($datos["user_create"])?$datos["user_create"]:null;            	
        $this->user_update=isset($datos["user_update"])?$datos["user_update"]:null;  

    }

    

    public function nuevaRsvQuincho($data=array()){
        
        self::cargarCampos($data);
             $array=array
             (
                'id_uth'=>$this->id_uth,
                'id_unidad'=>$this->id_unidad,
                'fecha_uso'=>$this->fecha_uso,            	
                'estado'=>$this->estado,                	
                'pago_reserva'=>$this->pago_reserva,           	
                'medio_garantia'=>$this->medio_garantia,       	
                'img_trasaccion'=>$this->img_trasaccion,         	
                'tiempo_reserva'=>$this->tiempo_reserva,        	
                'monto_multa'=>$this->monto_multa,            	
                'motivo_multa'=>$this->motivo_multa,           	
                'estado_entrega'=>$this->estado_entrega,         	
                'observacion_entrega'=>$this->observacion_entrega,    	
                'estado_recibido'=>$this->estado_recibido,        	
                'observacion_recibido'=>$this->observacion_recibido,  	
                'observacion_cancelacion'=>$this->observacion_cancelacion,	
                'condicion'=>$this->condicion,
                'activo'=>$this->activo,
                'date_update'=>$this->date_update,            	
                'user_create'=>$this->user_create,            	
                'user_update'=>$this->user_update,  
             );

               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        
    }
    
    public function marcarReserva(Adapter $dbAdapter,$fecha){
        
        $this->dbAdapter=$dbAdapter;
        
        $query="select id_uth,(select id_uso from sis_m_uth j where j.id=q.id_uth) as uso,estado,(select count(*)
                from sis_m_uth uth,sis_m_turno t,sis_m_uso u 
                where uth.id_turno=t.id and uth.id_uso=u.id 
                and weekday('".$fecha."') between t.nro1 and t.nro2
                and u.seccion='Quincho' and u.activo=1) as total
                from sis_w_rsv_quincho q where fecha_uso='".$fecha."' and activo=1";
        

        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
        
       
    }


    
    public function disponibleQuinchoDia(Adapter $dbAdapter,$fecha){
        
        $this->dbAdapter=$dbAdapter;
        
        $query="select u.id,u.nombre,u.alias,u.reserva,u.garantia,u.estado,u.capacidad,count(*) as thorario
                from sis_m_uth uth,sis_m_turno t,sis_m_uso u 
                where uth.id_turno=t.id and uth.id_uso=u.id 
                and weekday('".$fecha."') between t.nro1 and t.nro2
                and u.seccion='Quincho' and u.activo=1 group by u.id";
        

        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
        
       
    }
    
    public function listadoQuincho(Adapter $dbAdapter,$id)
    {
        $this->dbAdapter = $dbAdapter;
        $query="select * from sis_m_uso where seccion='Quincho' and activo = 1";
        
        if($id>0){
            $query=$query." and id=".$id;
        }
        
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray(); 
    }
    public function detalleQuincho(Adapter $dbAdapter,$id_uso,$fecha)
    {
        $this->dbAdapter=$dbAdapter;
        $query="select uth.id,uth.id_uso,uth.id_turno,uth.id_horario,
                uth.reserva_extra,t.nombre as nombreTurno,
                t.alias as aliasTurno,h.nombre as nombreHorario,h.alias as aliasHorario,
                h.inicio,h.fin from sis_m_uth uth, sis_m_turno t, sis_m_horario h 
                where uth.id_turno = t.id and uth.id_horario=h.id 
                and uth.id_uso=".$id_uso." and WEEKDAY('".$fecha."') between t.nro1 and t.nro2";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
    }
    
    public function estadoHorarioQuincho(Adapter $dbAdapter,$fecha)
    {
         $this->dbAdapter=$dbAdapter;
        $query="SELECT estado,id_uth,(select nombre from sis_m_unidad u where u.id=q.id_unidad) as 
        unidad,12-truncate(Timestampdiff(second,date_start,now())/3600,2) as horas FROM sis_w_rsv_quincho q where  fecha_uso='".$fecha."'and activo=1
        ";
        $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
        return $result->toArray();
    }
    
    public function obtenerFechaPasado(Adapter $dbAdapter,$mes,$anio){
         $this->dbAdapter=$dbAdapter;
         $query="select distinct day(fecha_uso) as dia,fecha_uso from sis_w_rsv_quincho where activo=1 and fecha_uso <curdate() and month(fecha_uso)=".$mes." and year(fecha_uso)=".$anio;
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();   
    }
    
    public function historiaQuincho(Adapter $dbAdapter,$fecha)
    {
         $this->dbAdapter=$dbAdapter;
         $query="select q.id as idRsv,q.condicion,q.id_unidad,(select nombre from sis_m_unidad un where un.id=q.id_unidad) as dpto,
                 u.id,u.nombre,u.alias,u.capacidad,u.garantia,u.reserva,
                 q.estado,q.pago_reserva,q.monto_multa,concat(h.inicio,'-',h.fin) as turno,
                 q.estado_entrega,q.estado_recibido
                 from sis_w_rsv_quincho q, sis_m_uso u, sis_m_horario h, sis_m_uth uth
                 where q.fecha_uso='".$fecha."' 
                 and uth.id=q.id_uth and uth.id_uso=u.id and uth.id_horario=h.id order by u.id";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();         
    }
    
    public function limpiarReserva(Adapter $dbAdapter,$mes,$anio,$user,$date_update)
    {
        $this->dbAdapter=$dbAdapter;
         $query="select id,12-truncate(Timestampdiff(second,date_start,now())/3600,2) as horas 
                    from sis_w_rsv_quincho where  month(fecha_uso)=".$mes." and year(fecha_uso)=".$anio." 
                    and activo=1 and estado='PreReserva'";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         $datos = $result->toArray();
         $oc="Se libera por tiempo de espera excedido en 12 horas";
         for($i=0;$i<count($datos);$i++)
         {
            $tm = (float)$datos[$i]['horas'];
            if ($tm<=0){
                $array = array("activo"=>0,"condicion"=>"Cancelado","observacion_cancelacion"=>$oc,"date_update"=>$date_update,"user_update"=>$user);
                self::actualizarRsvQuincho($datos[$i]['id'],$array);
            }
         } 
         
    }
    public function actualizarRsvQuincho($id, $data=array())
    {
        $this->update($data, array('id' => $id));
    }
    
    public function verDptoQuincho(Adapter $dbAdapter,$dpto)
    {
        
         $this->dbAdapter=$dbAdapter;
         $query="SELECT q.id, 
         (select alias from sis_m_uso where id=uth.id_uso) as aliasq,
         fecha_uso, 
            (select concat(inicio,'-',fin) from sis_m_horario where id=uth.id_horario) as turno,
            estado_entrega,estado_recibido,estado,
            12-truncate(Timestampdiff(second,q.date_start,now())/3600,2) as horas
            ,condicion,monto_multa,q.activo
            FROM sis_w_rsv_quincho q,sis_m_uth uth
            where id_unidad = (select id from sis_m_unidad where activo=1 and nombre='".$dpto."') 
            and uth.id=q.id_uth order by fecha_uso desc
            limit 10 ";
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();  
        
        
    }
    
    public function ajusteDetalleQuincho(Adapter $dbAdapter,$id)
    {
        
         $this->dbAdapter=$dbAdapter;
         $query="select q.id,
                    u.nombre as nombre_uso,u.alias as alias_uso,u.estado as estado_uso,u.capacidad,u.reserva as reserva_uso,u.garantia,
                    h.alias as alias_horario,h.inicio,h.fin,
                    (select nombre from sis_m_unidad un where un.id = q.id_unidad ) as nombre_unidad,
                    q.fecha_uso,q.estado as estado_quincho,q.pago_reserva,q.img_trasaccion,
                    q.tiempo_reserva,q.monto_multa,q.motivo_multa,q.estado_entrega,q.observacion_entrega,
                    q.estado_recibido,q.observacion_recibido,q.observacion_cancelacion,q.condicion,
                    q.date_start,q.date_update,
                    (select concat(nombre,' ',apellido) from thouseap_general.sis_m_persona p where p.id=q.user_create) as registro,
                    (select concat(nombre,' ',apellido) from thouseap_general.sis_m_persona p where p.id=q.user_update) as actualizo
                    from sis_w_rsv_quincho q,
                    sis_m_uth uth,
                    sis_m_uso u,
                    sis_m_horario h
                    where q.id_uth=uth.id and uth.id_uso=u.id 
                     and uth.id_horario = h.id
                    and q.id=".$id;
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();  
        
        
    }    
    
    public function mostrarHorarioNombreQuincho(Adapter $dbAdapter,$id)
    {
        
         $this->dbAdapter=$dbAdapter;
         $query="select u.nombre,h.inicio,h.fin from sis_m_horario h , 
             sis_m_uso u, sis_m_turno t,sis_m_uth uth 
               where uth.id_horario=h.id and uth.id_uso=u.id and uth.id_turno=t.id and uth.id=".$id;
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result->toArray();  
        
        
    } 
    
    
    

}