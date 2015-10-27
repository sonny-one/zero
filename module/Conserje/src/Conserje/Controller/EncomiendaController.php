<?php



namespace Conserje\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Session\Container;
use Sistema\Model\Entity\EncomiendaTable;
use Sistema\Model\Entity\PersonaDetTable;

use Sistema\Model\Entity\UnidadTable;

use Sistema\Util\SysFnc;
use Conserje\Form\EncomiendaForm;


use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;



class EncomiendaController extends AbstractActionController

{
    public function indexAction()

    {
        $this->layout('layout/conserje');
        
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $enc = new EncomiendaTable($this->dbAdapter);
        $lst = $enc->getUltimasEncAbierta($this->dbAdapter);
      
                                       
        $info='<table class="table table-hover">
               <thead><tr><th>Para</th><th>Remitente</th><th>Fecha que lleg&oacute;</th><th>Descripci&oacute;n</th><th>Ver Foto</th><th>Retirar</th></tr></thead>
               <tbody style="text-align: center;">';
               
               //dpto     nombres                         fecha_ingreso        detalle          foto                                                                   
        for($i=0;$i<count($lst);$i++){
            $fichero =  "/files/db/".$id_db."/conserje/encomienda/".$lst[$i]['foto'];
            $rut_format = SysFnc::rutFormat($lst[$i]['rut_titular'],$lst[$i]['dv_titular']);
            
            $info=$info." <tr><td>".$lst[$i]['dpto']."</td>
                              <td>".$lst[$i]['nombres']."</td>
                              <td>".$lst[$i]['fecha_ingreso']."</td>
                              <td><a href='javascript:void()' onclick='mostrarDetalle(&apos;".$lst[$i]['fecha_ingreso']."&apos;,&apos;".$lst[$i]['dpto']."&apos;,&apos;".$lst[$i]['nombres']."&apos;,&apos;".$lst[$i]['detalle']."&apos;)' data-toggle='modal' data-target='#modalDetalle'>".$lst[$i]['detalle_corto']."</a></td>
                              <td><a href='".$fichero."' target='_blank'>".$lst[$i]['foto_corto']."</a></td>
                              <td><a href='javascript:void()' onclick='retirarEncomienda(&apos;".$lst[$i]['id']."&apos;,&apos;".$lst[$i]['id_persona']."&apos;,&apos;".$lst[$i]['nombre_titular']."&apos;,&apos;".$rut_format."&apos;,&apos;".$lst[$i]['dpto']."&apos;,&apos;".$lst[$i]['nombres']."&apos;)' data-toggle='modal' data-target='#modalRetirarEnc'><i class='fa fa-check-square fa-fw fa-1x'></i></a></td></tr>";
        }
          
                                      
        $info=$info.'</tbody></table>';
           
        return new ViewModel(array('info'=>$info,'rsptaOK'=>SysFnc::rspOK(),'nuevaPersona'=>SysFnc::nuevaPersona()));
    }

    public function nuevoAction()
    {
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if($this->getRequest()->isPost()){
            $lista = $this->request->getPost();
            $encomienda->nuevaEncomienda($lista);
        }
        else{
        $form=new EncomiendaForm("form");                
        $dpto = new UnidadTable($this->dbAdapter);
        $lista = $dpto->getDatosActivos(); 
        $form->get('id_dpto')->setAttribute('options' ,$lista);
        $this->layout('layout/conserje');
        $valores = array('form'=>$form,'rsptaOK'=>SysFnc::rspOK(),'nuevaPersona'=>SysFnc::nuevaPersona());
        return new ViewModel($valores);
        }

    }

    

    public function cerrarAction()

    {
        $lista = array(1,2,3);
        $result = new ViewModel(array('lista'=>$lista));
        $result->setTerminal(true);   
        return $result;

    }

    

    public function buscarAction()

    {

        $this->layout('layout/conserje');
        

           

        return new ViewModel(array("rsptaOK"=>SysFnc::rspOK(),"nuevaPersona"=>SysFnc::nuevaPersona()));

    }
    
    public function residentesAction()
    {
        $variable = $this->request->getPost();
        
        $sid = new Container('base');                                      
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $dpto = new UnidadTable($this->dbAdapter);
        $lista = $dpto->getVerResidentesActivos($this->dbAdapter,$variable['id_unidad']);
        $tabla="";
        $status="ok";
        

        if(count($lista)>0){
            $tabla="<table class='table table-hover table-bordered'><caption>Viven en el departamento</caption><thead><tr><th>Nombres y Apellidos</th><th>Correo</th><th>Notifica</th></tr></thead><tbody style='text-align: center;'>";
            for($i=0;$i<count($lista);$i++){
                
                   $tabla=$tabla."<tr><td>".$lista[$i]['nombre']."</td><td>".$lista[$i]['correo']."</td><td><input type='checkbox' checked/></td></tr>";
                
            }
            $tabla=$tabla."</tbody></table>";
        }
        return new JsonModel(
                        array(
                        'status'=>$status,

                        'tabla'=>$tabla
                        )
                        );                                

    }
    
    public function registrarAction()
    {
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $status="";$error="";
        if(isset($id_usuario)){
            $fechaCompleta=SysFnc::FechaActualYmdHms();
            $v = $this->request->getPost();
            if(isset($v['id_persona_remite'])&& (int)$v['id_persona_remite']>0){

                $db_name = $sid->offsetGet('dbNombre');
                $this->dbAdapter=$this->getServiceLocator()->get($db_name);
                $encomienda = new EncomiendaTable($this->dbAdapter);
                
                $File    = $this->params()->fromFiles('fileData');
                
                $adapterFile = new \Zend\File\Transfer\Adapter\Http();
                $adapterFile->setDestination($_SERVER['DOCUMENT_ROOT'].'/files/db/'.$id_db.'/conserje/encomienda');
                $adapterFile->receive($File['name']);
                $nombreArchivoEnc = isset($File['name'])?$File['name']:"";
              
                    $datos = array(
                    'id_unidad'=>$v['id_unidad'],
                    'id_persona_remite'=>$v['id_persona_remite'],
                    'detalle'=>$v['detalle'],
                    'fecha_ingreso'=>$fechaCompleta,
                    'date_update'=>$fechaCompleta,
                    'user_create'=>$id_usuario,
                    'foto'=>$nombreArchivoEnc
                    );
                    $idEnc = $encomienda->nuevaEncomienda($datos);
                    
                    //Enviar Correo
                    
                                  
                    $dptoMail = new UnidadTable($this->dbAdapter);
                    $lista = $dptoMail->getVerResidentesActivos($this->dbAdapter,$v['id_unidad']);
                    
                    for($i=0;$i<count($lista);$i++)
                    {
                        if(isset($lista[$i]['correo'])){
                            $pos = strpos($lista[$i]['correo'], "@");
                            if($pos==false){}else
                            {
                                
                                $nombre = $lista[$i]['nombre'];
                                $remitente = $v['remitente'];
                                $descp="";
                                if($nombreArchivoEnc==""){
                                    $descp="No presenta fotografia";
                                    $filepath="";
                                }else{
                                    $filepath = 'http://becheck.cl/files/db/'.$id_db.'/conserje/encomienda/'.$nombreArchivoEnc;    
                                }
                                
                                    $htmlMarkup=\HtmlCorreo::htmlEncomienda($nombre,$remitente,$filepath);
                                    $html = new MimePart($htmlMarkup);
                                    $html->type = "text/html";
                                    $body = new MimeMessage();
                                    $body->setParts(array($html));
                                    $message = new Message();
                                    $message->addTo($lista[$i]['correo'])
                                    ->addFrom('soporte@becheck.cl', 'Sistema be check')
                                    ->setSubject('Aviso de Encomienda Recepcionada')
                                    ->setBody($body);
                                      $transport = new SendmailTransport();
                                      $transport->send($message);
                                
                                
                                sleep(2);
                                //enviamos correo
                            }
                            
                        }
                    }
                    
                    
                    //Fin Enviar Correo
                    
                    
                    $status="ok";
                
                
            }else{
                $status="nok";
                $error="el identificador del remitente no encontrado";
            }
            
            
            
            
        }else{
            $status="nok";
            $error="usuario no encontrado";
            
        }
        
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'error'=>$error
                        )
        ); 
    }
    
    public function retirarAction()
    {
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $status="";$error="";
        if(isset($id_usuario)){
            $fechaCompleta=SysFnc::FechaActualYmdHms();
            $v = $this->request->getPost();
            if(isset($v['id_encomienda'])&& (int)$v['id_encomienda']>0){

                $db_name = $sid->offsetGet('dbNombre');
                $this->dbAdapter=$this->getServiceLocator()->get($db_name);
                $encomienda = new EncomiendaTable($this->dbAdapter);
                    $v['fecha_salida']=$fechaCompleta;
                    $v['date_update']=$fechaCompleta;
                    $v['user_update']=$id_usuario;
                    $encomienda->cerrarEncomienda($v);
                    $status="ok";
            }else{
                $status="nok";
                $error="el identificador de encomienda no encontrado";
            }
        }else{
            $status="nok";
            $error="usuario no encontrado";
            
        }
        
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'error'=>$error
                        )
        ); 
    }
    
    public function lstencomiendaAction()
    {
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $id_usuario = $sid->offsetGet('id_usuario');
        $status="ok";$error="";$info="";
        if(isset($id_usuario)){
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $enc = new EncomiendaTable($this->dbAdapter);
        $estado="";$dpto="";$limit="";$titulo="";$info="";
        if($this->request->getPost()){
            $v = $this->request->getPost();
            
            $dpto = isset($v['dpto'])?$v['dpto']:"";
            $estado = isset($v['estado'])?$v['estado']:"";
            $titulo = isset($v['titulo'])?$v['titulo']:"";
            $limit = isset($v['limite'])?$v['limite']:"";
            
            
            
            
        }
        
        $lst = $enc->listarEncomiendas($this->dbAdapter,$estado,$dpto,$limit);
        $status="ok";$error="";
        $info='<table class="table table-bordered  table-hover">
        <caption><i>'.$titulo.' <b>Total: '.count($lst).' registros</b></i></caption>
               <thead><tr><th>Dpto</th><th>Llego</th><th>Remitente</th><th>Detalle</th><th>Estado</th><th>Retirar</th><th>Notificar</th></tr></thead>
               <tbody style="text-align: center;">';
            if(count($lst)>0){   
                for($i=0;$i<count($lst);$i++){
                    $estado = $lst[$i]['estado'];
                    $class="class='success'";
                    $rut_format = SysFnc::rutFormat($lst[$i]['rut_titular'],$lst[$i]['dv_titular']);
                    if($estado=="Abierto"){
                        $class="class='active'";
                    }
                    //Determinar alarma 7 dias despues
                    $dia = SysFnc::difDays($lst[$i]['fecha_ingreso']);
                    if($dia>6 && $estado=="Abierto"){
                       $class="class='danger'";
                       $mostrarEstado="<span class='blink_me'><font color=red>".$estado."</font></span>"; 
                    }else{
                        $mostrarEstado=$estado;
                    }
                   
                    $info=$info." <tr><td ".$class."><strong>".$lst[$i]['dpto']."</strong></td>
                                      <td ".$class.">".$lst[$i]['fecha_ingreso']."</td>
                                      <td ".$class.">".$lst[$i]['nombres']."</td>
                                      <td ".$class."><a href='javascript:void()' onclick='verDetalleEnc(&apos;".$lst[$i]['id']."&apos;,&apos;".$lst[$i]['id_unidad']."&apos;)'  data-toggle='modal' data-target='#modalDetalleEncomienda'><i class='fa fa-eye fa-fw fa-1x'></i></a></td>
                                      <td ".$class.">".$mostrarEstado."</td>";
                                      if($estado=="Abierto"){
                                        $info=$info."<td ".$class."><a  href='javascript:void()' onclick='retirarEncomienda(&apos;".$lst[$i]['id']."&apos;,&apos;".$lst[$i]['id_persona']."&apos;,&apos;".$lst[$i]['nombre_titular']."&apos;,&apos;".$rut_format."&apos;,&apos;".$lst[$i]['dpto']."&apos;,&apos;".$lst[$i]['nombres']."&apos;)' data-toggle='modal' data-target='#modalRetirarEnc'><i class='fa fa-check-square fa-fw fa-1x'></i></a></td>
                                                   <td ".$class."><a href='#'><i class='fa fa-envelope-square fa-fw fa-1x'></i></a></td></tr>";
                                      }else{
                                        $info=$info."<td ".$class.">NA</td>
                                                   <td ".$class.">NA</td></tr>";
                                        
                                      }
                }
            }else{
               $info=$info." <tr><td colspan='7'><i>No hay registros...</i></td></tr>"; 
            }
            
        
        $info=$info.'</tbody></table>';
        }else{
            $status="nok";
            $error="La sesion ha caducado, vuelva ingresar al sistema";
        }
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'error'=>$error,
                        'info'=>$info
                        ));
    }
    
    public function verdetencAction()
    {
         $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $id_usuario = $sid->offsetGet('id_usuario');
        $status="ok";$error="";$modal="";
        if(isset($id_usuario)){
       
        
        if($this->request->getPost()){
            $v = $this->request->getPost();
             $this->dbAdapter=$this->getServiceLocator()->get($db_name);
             $enc = new EncomiendaTable($this->dbAdapter);
             $perdet = new PersonaDetTable($this->dbAdapter);
             $datosEnc = $enc->detalleEnconmienda($this->dbAdapter,$v['id']);
             $dataPer = $perdet->getHabitanDpto($this->dbAdapter,$v['id_unidad']);
             $habitan="";
             for($i=0;$i<count($dataPer);$i++){
                $habitan=$habitan." <tr><td>".$dataPer[$i]['nombres']."</td><td>".$dataPer[$i]['telefono']."</td><td>".$dataPer[$i]['condicion']."</td></tr>";
             }
             $vector=array('dpto'=>'Departamento: '.$datosEnc[0]['dpto'],'estado'=>$datosEnc[0]['estado'],
             'habitan'=>$habitan,'remite'=>$datosEnc[0]['remite'],'retirado'=>isset($datosEnc[0]['retira'])?$datosEnc[0]['retira']:'',
             'fecha'=>$datosEnc[0]['fecha_ingreso'],'detalle'=>$datosEnc[0]['detalle'],'observacion'=>$datosEnc[0]['observacion'],
             'ingresado'=>$datosEnc[0]['registrado'],'actualizado'=>isset($datosEnc[0]['actualizado'])?$datosEnc[0]['actualizado']:'',
             'date_update'=>isset($datosEnc[0]['date_update'])?$datosEnc[0]['date_update']:''
             );
             $modal = SysFnc::detalleEnc($vector);
            
        }else{
            $status="nok";
            $error="Parametros de entradas vacios"; 

        }
        }else{
            $status="nok";
            $error="La sesion ha caducado, vuelva ingresar al sistema"; 
        }
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'error'=>$error,
                        'modal'=>$modal
                        ));
    }    

}