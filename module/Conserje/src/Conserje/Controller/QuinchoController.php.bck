<?php
namespace Conserje\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Sistema\Model\Entity\UnidadTable;
use Sistema\Model\Entity\RsvQuinchoTable;
use Sistema\Util\SysFnc;
use Sistema\Util\UsoFnc;

use Zend\Session\Container;


class QuinchoController extends AbstractActionController

{
    public $dbAdapter;

    public function indexAction()
    {
                                             
        $this->layout('layout/conserje');
        
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $dpto = new UnidadTable($this->dbAdapter);
        $lista = $dpto->getDatosActivos(); 
        $sDpto = "<select name='id_unidad' id='id_unidad' class='form-control'>";
       
        foreach($lista as $key => $value)
        {
           $sDpto = $sDpto."<option value='".$key."'>".$value."</option>";
        }
           $sDpto = $sDpto."</select>";
        
        //$sid->offsetSet('sDpto',$sDpto);
        $sid->offsetSet('dpto',$sDpto);
      
        return new ViewModel(array('rsptaOK'=>SysFnc::rspOK(),'imgView'=>SysFnc::cargarVistaImagen()));
    }

    
    public function operaAction(){
        
       
       
       if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {

           $sid = new Container('base');
           $id_usuario = $sid->offsetGet('id_usuario');
           $db_name = $sid->offsetGet('dbNombre');
           $this->dbAdapter=$this->getServiceLocator()->get($db_name);
           $usoQ = new RsvQuinchoTable($this->dbAdapter);
            $fechaActual = SysFnc::FechaActualYmd();
            
            
            
            $pi = strtotime($fechaActual);
            $year = intval($_REQUEST['year']);
            $month = intval($_REQUEST['month']);
            
            $lastday = intval(strftime('%d', mktime(0, 0, 0, ($month == 12 ? 1 : $month + 1), 0, ($month == 12 ? $year + 1 : $year))));


            //limpiamos la prereserva
            $usoQ->limpiarReserva($this->dbAdapter,$month,$year,$id_usuario,$fechaActual);
                $dates = array();
               
                for ($i = 1; $i <= $lastday; $i++) {
                    $date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT).'-';
                    if($i<10){
                        $date = $date . '0'.$i.'';
                    }else{
                        $date = $date.$i.'';
                    }
                     
                    $pf = strtotime($date);
                    $viewQuincho='';
                    if($pf>=$pi){
                        $lstUsoQ = $usoQ->disponibleQuinchoDia($this->dbAdapter,$date);
                        $hayQuincho = count($lstUsoQ)>0?true:false;        
                           
                        if($hayQuincho){
                            
                            $marcarRsv = $usoQ->marcarReserva($this->dbAdapter,$date);
                            $classForNameDia = 'btn-success';
                            $classForName = 'btn-success';
                            $totalRsv = count($marcarRsv);
                            $redo=false;
                            $estadoRsv = 'Libre';
                            if($totalRsv>0){
                                $redo=true;
                               if($totalRsv == $marcarRsv[0]['total']){
                                 $classForNameDia = 'btn-danger';
                                }else{
                                  $classForNameDia = 'btn-primary';
                                }
                            }
                                    

                            for($m1=0;$m1<count($lstUsoQ);$m1++){
                                 if($totalRsv>0){
                                    if($classForNameDia == 'btn-danger'){
                                        $classForName = 'btn-danger';
                                        $estadoRsv = 'Ocupado';
                                    }else{
                                     $classForName = 'btn-success';
                                     $estadoRsv = 'Libre';
                                    $codUso = array();
                                    for($t1=0;$t1<$totalRsv;$t1++){
                                        array_push($codUso,$marcarRsv[$t1]['uso']); 
                                    }
                                    $arrayCnt = SysFnc::repeatedElements($codUso);
                                    
                                    
                                        for($t2=0;$t2<count($arrayCnt);$t2++){
                                            if($lstUsoQ[$m1]['id']==$arrayCnt[$t2]['value']){
                                                if($lstUsoQ[$m1]['thorario']==$arrayCnt[$t2]['count']){
                                                    $classForName = 'btn-danger';
                                                    $estadoRsv = 'Ocupado';
                                                }else{
                                                    $classForName = 'btn-primary';
                                                    $estadoRsv = 'Parcial';
                                                    }
                                                break;
                                            }
                                        }
                                    }
                                }
                                
                                $viewQuincho = $viewQuincho.UsoFnc::bloqueDivQuincho($lstUsoQ[$m1]['id'],$date,$classForName,$lstUsoQ[$m1]['nombre'],$lstUsoQ[$m1]['alias'],$lstUsoQ[$m1]['capacidad'],$lstUsoQ[$m1]['estado'],$lstUsoQ[$m1]['garantia'],$lstUsoQ[$m1]['reserva'],$estadoRsv);
                            }
                            
                                // seteamos los dias redo = true marca el dia
                                $dates[$i] = array(
                                    'date' => $date,
                                    'badge' => $redo,
                                    'title' => SysFnc::mostrarFecha($date),
                                    'body' => $viewQuincho,
                                    'footer'=>'',
                                );
                        
                                
                            $dates[$i]['classname'] = $classForNameDia;
                        
                        }
                    }else{
                       
                    }
                    
                    
                    //setamos los history
                    
                    if($i == $lastday){
                       
                       
                        $pasado = $usoQ->obtenerFechaPasado($this->dbAdapter,$month,$year);
                        
                        for($y=0;$y<count($pasado);$y++){
                            
                            $listado=$usoQ->historiaQuincho($this->dbAdapter,$pasado[$y]['fecha_uso']);
                            
                            $dates[$pasado[$y]['dia']] = array
                            (
                            'date' => $pasado[$y]['fecha_uso'],
                            'badge' => true,
                            'title' => SysFnc::mostrarFecha($pasado[$y]['fecha_uso']),
                            'body' => UsoFnc::historiaQuincho($listado,$pasado[$y]['fecha_uso']),
                            'footer'=>'',
                            'classname'=>'grade-default',
                            );
                        }
                        
                        
                    }
                   
            
                    
                }

            

            } else {
                $dates = array();
            }

       
       
              
                  
        
        $result = new JsonModel($dates);                                

        return $result; 
    }
    
    public function detalleAction(){
        
        $status = "nok";
        $error="Error en Ajax";
        $bodyDiv="";
        
        if (!empty($_REQUEST['id_uso']) && !empty($_REQUEST['fecha'])) {
            
            
            
            
            
            $id_uso = $_REQUEST['id_uso'];
            $fecha =  $_REQUEST['fecha'];
            $sid = new Container('base');
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $infoQ = new RsvQuinchoTable($this->dbAdapter);
            
            
            
            
            $usoQ = $infoQ->listadoQuincho($this->dbAdapter,$id_uso);
            $detalleQ = $infoQ->detalleQuincho($this->dbAdapter,$id_uso,$fecha);
            $rsvQ = $infoQ->estadoHorarioQuincho($this->dbAdapter,$fecha);
            $horario = array();
            for($i=0;$i<count($detalleQ);$i++)
            {
                $valor="";
                $unidad="";
                $horas="";
                for($i1=0;$i1<count($rsvQ);$i1++){
                 if($detalleQ[$i]['id']==$rsvQ[$i1]['id_uth']){
                        $valor=$rsvQ[$i1]['estado'];
                        $unidad=$rsvQ[$i1]['unidad'];
                        $horas = $rsvQ[$i1]['horas'];
                        $break;
                 }   
                }
                
                $horario[$i] = array('id'=>$detalleQ[$i]['id'],'inicio'=>$detalleQ[$i]['inicio'],'fin'=>$detalleQ[$i]['fin'],'valor'=>$valor,'unidad'=>$unidad,'horas'=>$horas);
            }
            
            if(count($usoQ)>0){
                $bodyDiv=UsoFnc::detalleRsvQuincho($fecha,$usoQ[0]['nombre'],$usoQ[0]['alias'],$usoQ[0]['capacidad'],$usoQ[0]['reserva'],$usoQ[0]['garantia'],$horario);
                $status="ok";
                $error="";
            }else{
                $error="Error: Quincho se encuentra inactivo";
            }
            
            
        
        }
        
        $datos = array('status'=>$status,'error'=>$error,'bodyDiv'=>$bodyDiv);
        
        
        $result = new JsonModel($datos); 
        
        return $result;
    
    }
    
    public function newrsvAction(){

        $sid = new Container('base');
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $prm = $this->request->getPost();
        
        // ACA ME QUEDE
        if (isset($id_usuario) && !empty($prm['id_uth']) && !empty($prm['fecha_uso'])) {
            
            
             
            $id_uth = $prm['id_uth'];
            $id_unidad =  $prm['id_unidad'];
            $fecha_uso =  $prm['fecha_uso'];
            $estado =  $prm['estado'];
            $pago_reserva =  $prm['pago_reserva'];
            $medio_garantia =  $prm['medio_garantia'];
            //$img_trasaccion =  $prm['img_trasaccion'];
            $tiempo_reserva =  $prm['tiempo_reserva'];
            $observacion_entrega = $prm['observacion_entrega'];
            
            $File    = $this->params()->fromFiles('fileData');
                
                $adapterFile = new \Zend\File\Transfer\Adapter\Http();
                $adapterFile->setDestination($_SERVER['DOCUMENT_ROOT'].'/files/db/'.$id_db.'/conserje/quincho');
                $adapterFile->receive($File['name']);
            
            $img_trasaccion=isset($File['name'])?$File['name']:"";
            $entrega="";$condicion="";
            if($estado=="Reserva"){
                $entrega="OK";
                $condicion="Abierto";
            }
            if($estado=="PreReserva"){
                $condicion="En Espera";
            }
            
            $datos = array('id_uth'=>$id_uth,'id_unidad'=>$id_unidad,'fecha_uso'=>$fecha_uso,'estado'=>$estado,
            'pago_reserva'=>$pago_reserva,'medio_garantia'=>$medio_garantia,'estado_entrega'=>$entrega,'condicion'=>$condicion,
            'img_trasaccion'=>$img_trasaccion,'tiempo_reserva'=>$tiempo_reserva,'user_create'=>$id_usuario,'observacion_entrega'=>$observacion_entrega);
            

            
            
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $rsvQ = new RsvQuinchoTable($this->dbAdapter);
            $usoQ = $rsvQ->nuevaRsvQuincho($datos);
            
            
            
            $status="ok";
            $error="";
            
            
        
        }else{
            $status="nok";
            $error="Error interno, posiblemente ha caducado la sesion";
        }
        
        $datos = array('status'=>$status,'error'=>$error);
        
        
        $result = new JsonModel($datos); 
        
        return $result;        
        
        
    }
    public function datosqAction()
    {
       
       $error="";
       $status="";
       $editDiv="";
       
        $sid = new Container('base');
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $prm = $this->request->getPost();
        
         if (isset($id_usuario) && !empty($prm['dptoB'])) {
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $vD = new RsvQuinchoTable($this->dbAdapter);
            $miarray = $vD->verDptoQuincho($this->dbAdapter,$prm['dptoB']);
            
            $status="ok";
            $editDiv=UsoFnc::editarQuincho($miarray);
         }else{
                $error="Se ha caducado la sesion o parametro incorrecto";
         }
        
        
        $datos = array('status'=>$status,'error'=>$error,'editDiv'=>$editDiv);
        $result = new JsonModel($datos); 
        
        return $result;  
        
    }
    
    public function ajusteAction()
    {
        $error="";
       $status="";
       $editDiv="";
       
        $sid = new Container('base');
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $prm = $this->request->getPost();
        
         if (isset($id_usuario) && !empty($prm['id'])) {
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $vD = new RsvQuinchoTable($this->dbAdapter);
            $miarray = $vD->ajusteDetalleQuincho($this->dbAdapter,$prm['id'],SysFnc::FechaActualYmd());
            
            $status="ok";
            $editDiv=UsoFnc::ajuste($miarray,SysFnc::FechaActualYmd(),$id_db);
         }else{
                $error="Se ha caducado la sesion o parametro incorrecto";
         }
        
        
        $datos = array('status'=>$status,'error'=>$error,'ajusteBody'=>$editDiv);
        $result = new JsonModel($datos); 
        
        return $result; 
    }
    
    public function aqoperAction()
    {
        $error="";
        $status="";
        $msj="";
        $sid = new Container('base');
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $prm = $this->request->getPost();
        
         if (isset($id_usuario) && !empty($prm['id'])&& !empty($prm['oper'])) {
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $vD = new RsvQuinchoTable($this->dbAdapter);
            
            if($prm['oper']=="finalizaOK")
            {
                $data=array('estado_recibido'=>'OK','condicion'=>'Cerrado','user_update'=>$id_usuario,'date_update'=>SysFnc::FechaActualYmdHms());
                $vD->actualizarRsvQuincho($prm['id'],$data);
                $msj="Se ha finalizado la reserva satisfactoriamente...";
            }
            if($prm['oper']=="anulaReserva")
            {
                $data=array('activo'=>0,'estado_entrega'=>'','observacion_entrega'=>'','observacion_cancelacion'=>$prm['obs'],'condicion'=>'Cancelado','user_update'=>$id_usuario,'date_update'=>SysFnc::FechaActualYmdHms());
                $vD->actualizarRsvQuincho($prm['id'],$data);
                $msj="Se ha cancelado la reserva satisfactoriamente...";
            }
             if($prm['oper']=="finalizaNOK")
            {
                $data=array('estado_recibido'=>'NOK','observacion_recibido'=>$prm['obs'],'condicion'=>'Cerrado','user_update'=>$id_usuario,'date_update'=>SysFnc::FechaActualYmdHms());
                $vD->actualizarRsvQuincho($prm['id'],$data);
                $msj="Se ha finalizado con observacion la reserva satisfactoriamente...";
            }            
            if($prm['oper']=="finalizaM")
            {
                $data=array('estado_recibido'=>'NOK','motivo_multa'=>$prm['obs'],'monto_multa'=>$prm['monto'],'condicion'=>'Cerrado','user_update'=>$id_usuario,'date_update'=>SysFnc::FechaActualYmdHms());
                $vD->actualizarRsvQuincho($prm['id'],$data);
                $msj="Se ha finalizado con multa la reserva satisfactoriamente...";
            }

            
            
            $status="ok";
            
         }else{
                $error="Se ha caducado la sesion o parametro incorrecto";
         }
        
        
        $datos = array('status'=>$status,'error'=>$error,'message'=>$msj);
        $result = new JsonModel($datos); 
        
        return $result;         
    }
    

    

}