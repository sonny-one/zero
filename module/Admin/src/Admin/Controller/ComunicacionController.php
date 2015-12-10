<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Sistema\Model\Entity\CircularTable;
use Sistema\Util\SysFnc;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;


class ComunicacionController extends AbstractActionController

{    
    
    public function indexAction()
    
    {                                       
        $this->layout('layout/admin');        
        $titulo = "Mi condominio";                                                              
        $valores = array('titulo'=>$titulo);        
        return new ViewModel($valores);
        
    }
    
    public function mensajesAction()    
    {
        $this->layout('layout/admin');   
        $result = new ViewModel();    
       // $result->setTerminal(true);        
    
        return $result;
        
    }
    
    public function detallemensajeAction()    
    {
        //$this->layout('layout/admin');   
        $result = new ViewModel();    
        $result->setTerminal(true);        
    
        return $result;
        
    }
    
    public function circularesAction()
    
    {
        $plantilla = $this->params()->fromRoute('id', '');
        
         if($plantilla=="comite"){
             $this->layout('layout/comite');
         }else{
             $this->layout('layout/admin'); 
         }
        
   
    
        return new ViewModel();
        
    }
    
    public function nuevocircularAction(){
       
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $status="";$mensaje="";$id="0";
        if(isset($id_usuario)){
            
                $db_name = $sid->offsetGet('dbNombre');
                $this->dbAdapter=$this->getServiceLocator()->get($db_name);
                $circular = new CircularTable($this->dbAdapter);
                
                $File    = $this->params()->fromFiles('fileData');
                
                $adapterFile = new \Zend\File\Transfer\Adapter\Http();
                $adapterFile->setDestination($_SERVER['DOCUMENT_ROOT'].'/files/db/'.$id_db.'/circulares');
                $adapterFile->receive($File['name']);
                $nombreArchivoCircular = isset($File['name'])?$File['name']:"";
                $tamanioArchivoCircular = isset($File['size'])?round(((int)$File['size'])/1024):"0 KB";
                
                //validamos si existe un fichero ya registrado
                $vfile = $circular->getCircularByName($this->dbAdapter, $nombreArchivoCircular);
                if(count($vfile)>0){
                     $status="nok";
                     $mensaje="El fichero ya existe en la base de datos, con fecha y hora: ".$vfile[0]['date_start'].". Favor de elegir otro Archivo ";
                }else{
                    $datos = array(
                    'descripcion_file'=>'',
                    'nombre_file'=>$nombreArchivoCircular,
                    'tamanio_file'=>$tamanioArchivoCircular." KB",
                    'destino'=>'Comunidad',
                    'estado'=>'Proceso',
                    'activo'=>'1',
                    'user_create'=>$id_usuario
                    );
                    $id = $circular->nuevoCircular($datos);
                    $status="ok";
                    $mensaje="Se ha registrado y enviado satisfactoriamente la actividad. Nro peticion: ".$id;
                    
                }
                    //Enviar Correo
            
            
        }else{
          $status="nok";
          $mensaje="usuario del sistema no encontrado, sesion time-out";
            
        }
        
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'mensaje'=>$mensaje,
                         'id'=>$id
                        )
        ); 

    }
    
    public function lstcircularAction(){
        $sid = new Container('base');
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $status="ok";$mensaje="";$tabla="";
        
        if(isset($id_usuario)){
        
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $circular = new CircularTable($this->dbAdapter);
            $lstc = $circular->getListaCirculares($this->dbAdapter);
            
            $tabla=$tabla."<table class='table table-condensed table-hover'>";
            $tamanio=count($lstc);
        
            if($tamanio>0){
                $tabla=$tabla."<thead><tr><th>Pet.</th><th>Circular</th><th>Tamaño</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Ver</th></tr></thead>";
                $tabla=$tabla."<tbody>";
                    for($i=0;$i<$tamanio;$i++){
                        $fichero =  "/files/db/".$id_db."/circulares/".$lstc[$i]['nombre_file'];
                        $linkFile = "<a href='".$fichero."' target='_blank'><i class='fa fa-file-pdf-o'></i></a>";
                        $tabla=$tabla."<tr>";
                        $tabla=$tabla."<td align='left'>".$lstc[$i]['id']."</td>";
                        $tabla=$tabla."<td align='left'>".$lstc[$i]['nombre_file']."</td>";
                        $tabla=$tabla."<td align='left'>".$lstc[$i]['tamanio_file']."</td>";
                        $tabla=$tabla."<td align='left'>".SysFnc::mostrarFechaDMY($lstc[$i]['date_start'])."</td>";
                        $tabla=$tabla."<td align='left'>".SysFnc::mostrarHoraHms($lstc[$i]['date_start'])."</td>";
                        $tabla=$tabla."<td align='left'>".$lstc[$i]['estado']."</td>";
                        $tabla=$tabla."<td align='left'>".$linkFile."</td>";
                        $tabla=$tabla."</tr>";        
                    }
                $tabla=$tabla."</tbody></table>";
            }else{

                $status="ok";
                $tabla=$tabla."<thead><tr><th>Resultado</th></thead>";
                $tabla=$tabla."<tbody><tr><td>No hay registro</td></tr>";
                $tabla=$tabla."</tbody></table>";

            }
        }else{
          $status="nok";
          $mensaje="usuario del sistema no encontrado, sesion time-out";
            
        }
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'mensaje'=>$mensaje,
                        'tabla'=>$tabla
                        )
        );
    }
    
    public function sendmailcircularAction(){
        //CORREOOOOOO
        
        $sid = new Container('base');
        $id_usuario = $sid->offsetGet('id_usuario');
        $id_db = $sid->offsetGet('id_db');
        $status="ok";$mensaje="";
        
        if(isset($id_usuario)){
            
            //por seguridad, se aplica consulta de la peticion. Debe existir y con estado Proceso
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $circularTable = new CircularTable($this->dbAdapter);
            //recuperamos nro de peticion de circular
            $lc = $this->request->getPost();
            $filtros = array('id'=>$lc['id_circular'],'estado'=>'Proceso');
             
            $lstCircular = $circularTable->getCircularByDatos($filtros);
            if(count($lstCircular)>0){
                // seteamos el link
                $link_circular = 'http://becheck.cl/files/db/'.$id_db.'/circulares/'.$lstCircular[0]['nombre_file'];
                //actualizamos la peticion de Proceso a Enviando
                $filtros = array('id'=>$lc['id_circular'],'estado'=>'Enviando','user_update'=>$id_usuario,'date_update'=>  SysFnc::FechaActualYmdHms());
                $circularTable->actualizarCircular($filtros);
                
                //obtenemos todos los correos de la comunidad
                $correos =$circularTable->getListadoCorreoActivos($this->dbAdapter);
                
                //enviando a la gentita...
                
                $tamanio=count($correos);
                if($tamanio>0){
                    //seteamos el link del descarga
                        
                    //seteamos para que no expire la trasaccion
                    set_time_limit(90);
                    //enviamos correo masivas
                    $transport = new SmtpTransport();
                    $options   = new SmtpOptions(array(
                                        'name'              => 'smtp.gmail.com',
                                        'host'              => 'smtp.gmail.com',
                                        'port' => '587',                        
                                        'connection_class'  => 'login',
                                        'connection_config' => array(
                                            'username' => 'sistema.becheck@gmail.com',
                                            'password' => 'xofita123',
                                            'ssl'      => 'tls',
                                            ),
                    ));                     
                    for($i=0;$i<$tamanio;$i++){
                         if(isset($correos[$i]['correo'])){
                               $pos = strpos($correos[$i]['correo'], "@");
                               if($pos==false){}else{
                                   //si utilizas temporalmente Encomienda
                                    $htmlMarkup=\HtmlCorreo::htmlcircular($correos[$i]['nombre'],$link_circular);
                                    $html = new MimePart($htmlMarkup);
                                    $html->type = "text/html";
                                     $body = new MimeMessage();
                                     $body->setParts(array($html));
                                     $message = new Message();
                                     $message->addTo($correos[$i]['correo'])
                                     ->addFrom('soporte@becheck.cl', 'Sistema be check')
                                     ->setSubject('AVISO: Nuevo Circular del Condominio')
                                     ->setBody($body);                                                                                                                 
                                       $transport->setOptions($options);
                                       $transport->send($message);
                                       sleep(0.5);
                                 }
                          }
                       }
                       
                       //actualizamos si fue enviado
                        $filtros = array('id'=>$lc['id_circular'],'estado'=>'Enviado OK','user_update'=>$id_usuario,'date_update'=>  SysFnc::FechaActualYmdHms());
                        $circularTable->actualizarCircular($filtros);
                }else{
                    $mensaje="No hay datos para enviar correo masivo a la comunidad";
                }
                $mensaje="Envio masivo de correo - OK";
            }else{
               $mensaje="No se envia correos por que no cumple la regla de negocio"; 
            }        
            
            
            
        }else{
          $status="nok";
          $mensaje="sesion time out";
            
        }
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'mensaje'=>$mensaje
                        )
        );
        
    }
    
    public function bibliotecaAction()    
    {
        $this->layout('layout/admin');   
        $result = new ViewModel();    
       // $result->setTerminal(true);        
    
        return $result;
        
    }   
    
     public function reclamosAction()    
    {
        $this->layout('layout/admin');   
        $result = new ViewModel();    
       // $result->setTerminal(true);        
    
        return $result;
        
    }
    
    
    public function sugerenciasAction()    
    {
         
         
          
        $result = new ViewModel();    
       // $result->setTerminal(true);        
    
        return $result;
        
    }



}

