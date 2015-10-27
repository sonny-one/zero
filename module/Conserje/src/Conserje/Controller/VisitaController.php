<?php
namespace Conserje\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Sistema\Model\Entity\General\PersonaTable;
use Conserje\Form\VisitaForm;
use Sistema\Model\Entity\UnidadTable;
use Sistema\Model\Entity\MotivoVisitaTable;
use Sistema\Model\Entity\EstacionamientoTable;
use Sistema\Model\Entity\VisitaTable;
use Sistema\Model\Entity\VisitaEstTable;
use Sistema\Model\Entity\PersonaDetTable;
use Sistema\Util\SysFnc;

use Zend\Session\Container;


class VisitaController extends AbstractActionController

{
    public $dbAdapter;

    public function indexAction()
    {
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $visita = new VisitaTable($this->dbAdapter);
        $lst = $visita->getListaUltimasVisitas($this->dbAdapter);
        $info="";
        for($i=0;$i<count($lst);$i++){
            $auto="";
            if($lst[$i]['con_auto']=='Si'){
                $auto="<i class='fa fa-car'></i>";
            }
            $pf = strtotime($lst[$i]['fecha_ingreso']);
            $mostrarF = date("d-m-Y H:i:s", $pf);
            $info=$info." <tr><td>".$lst[$i]['dpto']."</td>
                              <td>".$lst[$i]['nombres']."</td>
                              <td>".$mostrarF."</td>
                              <td>".$auto."</td>
                              <td>".$lst[$i]['patente']."</td>
                              <td>".$lst[$i]['estado']."</td></tr>";
        }                                        
        $this->layout('layout/conserje');
        
        
        return new ViewModel(array("info"=>$info));
    }

    public function registrarAction()
    {
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        $this->layout('layout/conserje');
        $time = time();
        $fechaCompleta=date("d-m-Y H:i:s", $time);
         setlocale(LC_TIME, 'spanish').': ';
        $mostrarFechaEst = ucfirst(iconv('ISO-8859-1', 'UTF-8', strftime('%A %d de %B del %Y', time())));
        
        
        $form=new VisitaForm("form");
        $unidad = new UnidadTable($this->dbAdapter);
        $motivo = new MotivoVisitaTable($this->dbAdapter);
        $form->get('id_unidad')->setAttribute('options' ,$unidad->getDatosActivos());
        $form->get('id_motivo')->setAttribute('options' ,$motivo->getDatosActivos());
        $form->get('fechaHoraV')->setAttribute('value',$fechaCompleta);
        
        $e = new EstacionamientoTable($this->dbAdapter);
        $mapa = $e->getEstVist($this->dbAdapter);
        
        return new ViewModel(array("form"=>$form,"mapa"=>$mapa,"mostrarFechaEst"=>$mostrarFechaEst,'rsptaOK'=>SysFnc::rspOK(),'nuevaPersona'=>SysFnc::nuevaPersona()));

    }
    
    public function verestacAction(){
        
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $this->layout('layout/conserje');
        $e = new EstacionamientoTable($this->dbAdapter);
        $mapa = $e->getEstVist($this->dbAdapter);
        return new ViewModel(array("mapa"=>$mapa));
        
    }

    public function rutAction(){
        
        $rut = $this->params()->fromRoute('id', 0);
         
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $persona = new PersonaTable($this->dbAdapter);
        $listaRut = $persona->getDatosRut($rut);
    
        for($i=0;$i<count($listaRut);$i++){
            $r_id = isset($listaRut[$i]['id'])?$listaRut[$i]['id']:"";
            $r_rut = isset($listaRut[$i]['rut'])?$listaRut[$i]['rut']:"";
            $r_dv =isset($listaRut[$i]['dv'])?$listaRut[$i]['dv']:"";
            $r_nombre = isset($listaRut[$i]['nombre'])?$listaRut[$i]['nombre']:"";
            $r_apellido = isset($listaRut[$i]['apellido'])?$listaRut[$i]['apellido']:"";
            $r_apellido_2 = isset($listaRut[$i]['apellido_2'])?$listaRut[$i]['apellido_2']:"";
            $r_telefono = isset($listaRut[$i]['telefono'])?$listaRut[$i]['telefono']:"";
            $r_correo = isset($listaRut[$i]['correo'])?$listaRut[$i]['correo']:"";
            $r_foto = isset($listaRut[$i]['foto'])?$listaRut[$i]['foto']:"avatar.png";
            $r_dni = isset($listaRut[$i]['dni'])?$listaRut[$i]['dni']:"";
            $datos[$i] = array("id"=>$r_id,"rut"=>$r_rut,"dv"=>$r_dv,"nombre"=>utf8_encode($r_nombre),
            "apellido"=>utf8_encode($r_apellido),"apellido2"=>utf8_encode($r_apellido_2),
            "telefono"=>$r_telefono,"correo"=>$r_correo,"foto"=>$r_foto,"dni"=>$r_dni);
        }           
        
        $result = new JsonModel($datos);                                

        return $result; 
    }
    
    public function dniAction(){
        
        $dni = $this->params()->fromRoute('id', 0);
         
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $persona = new PersonaTable($this->dbAdapter);
        $listaDni = $persona->getDatosRut($dni);
    
        for($i=0;$i<count($listaDni);$i++){
            $datos[$i] = array("rut"=>$listaDni[$i]['rut'],"dv"=>$listaDni[$i]['dv'],"nombre"=>utf8_encode($listaDni[$i]['nombre']),"apellido"=>utf8_encode($listaDni[$i]['apellido']),"apellido2"=>utf8_encode($listaDni[$i]['apellido_2']));
        }           
        
        $result = new JsonModel($datos);                                

        return $result; 
    }
    
    public function verdptoAction(){
        
        $variable = $this->request->getPost();
        
        $sid = new Container('base');                                      
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $dpto = new UnidadTable($this->dbAdapter);
        $lista = $dpto->getVerDpto($this->dbAdapter,$variable['idUnidad']);
        $nombreD1 = "";$titularD1="";$contactoD1="";$condicionD1="";$tablaD1="";
        $status="ok";
        if(count($lista)>0){
            $tablaD1="<table class='table table-hover'><thead><tr><th>Nombres</th><th>Contacto</th><th></th></tr></thead><tbody>";
            $nombreD1=$lista[0]['dpto'];
            for($i=0;$i<count($lista);$i++){
                if($lista[$i]['titular']=="1"){
                    $titularD1 = isset($lista[$i]['nombre'])?$lista[$i]['nombre']:"";
                    if(isset($lista[$i]['condicion'])){
                        $condicionD1 = $lista[$i]['condicion']=="A"?"Arrendatario":"Copropetario";
                    }
                    $contactoD1 = isset($lista[$i]['contacto'])?$lista[$i]['contacto']:"";
                }else{
                   $tablaD1=$tablaD1."<tr><td>".$lista[$i]['nombre']."</td><td>".$lista[$i]['contacto']."</td><td>".$lista[$i]['condicion']."</td></tr>";
                }
            }
            $tablaD1=$tablaD1."</tbody></table>";
        }
        return new JsonModel(
                        array(
                        'status'=>$status,
                        'nombreD1'=>$nombreD1,
                        'titularD1'=>$titularD1,
                        'contactoD1'=>$contactoD1,
                        'condicionD1'=>$condicionD1,
                        'tablaD1'=>$tablaD1
                        )
                        );                                


    }
    
    
    public function regvisAction(){
        
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $status="";$error="";
        if(isset($id_usuario)){
            $time = time();
            $fechaCompleta=date("Y-m-d H:i:s", $time);
            $v = $this->request->getPost();
            if(isset($v['id_persona_v'])&& (int)$v['id_persona_v']>0){
                $v['fecha_ingreso'] = $fechaCompleta;
                $v['date_update'] = $fechaCompleta;
                $v['user_create'] = $id_usuario;
                $db_name = $sid->offsetGet('dbNombre');
                $this->dbAdapter=$this->getServiceLocator()->get($db_name);
                $perdet = new PersonaDetTable($this->dbAdapter);
                $listaperdet = $perdet->getTitularDpto($v['id_unidad']);
                $v['id_persona_t']=$listaperdet[0]['id_persona'];
                $visita = new VisitaTable($this->dbAdapter);
                $idVisita = $visita->nuevaVisita($v);
                if((int)$v['id_estacionamiento']>0){
                    $visest = new VisitaEstTable($this->dbAdapter);
                    $datos = array("id_visita"=>$idVisita,"id_unidad"=>$v['id_unidad'],"id_estacionamiento"=>$v['id_estacionamiento'],
                    "patente"=>$v['patente'],"fecha_ingreso"=>$v['fecha_ingreso'],"aplica_multa"=>$v['aplica_multa'],
                    "user_create"=>$v['user_create']                   
                    );
                    $visest->nuevaVisitaEst($datos);
                }
                $status="ok";
                
            }else{
                $status="nok";
                $error="el identificador de la persona no encontrado";
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
    
    public function cfgestAction(){
        
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $status="";$error="";
        if(isset($id_usuario)){
            $time = time();
            $fechaCompleta=date("Y-m-d H:i:s", $time);
            $v = $this->request->getPost();
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $visita = new VisitaTable($this->dbAdapter);
            $visest = new VisitaEstTable($this->dbAdapter);
            $visest->eliminaEstVisita($v['id_est_visita']);
            $data=array("id_est_visita"=>$v['id_est_visita'],"id_visita"=>$v['id_visita'],"hora_diferencia"=>$v['hora_diferencia'],"fecha_salida"=>$fechaCompleta,"user_update"=>$id_usuario);
            $visita->actualizarVisitaEst($data);
            $status="ok";
            
            
       } else{
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
    
    public function cfgestbloqueoAction(){
        
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $status="";$error="";
        if(isset($id_usuario)){
            $time = time();
            $fechaCompleta=date("Y-m-d H:i:s", $time);
            $v = $this->request->getPost();
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $estacionamiento = new EstacionamientoTable($this->dbAdapter);
            $data=array("id"=>$v['id'],"date_update"=>$fechaCompleta);
            $estacionamiento->bloquearEst($data);
            $status="ok";
            
            
       } else{
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
    public function cfgestdesbloqueoAction(){
        
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $status="";$error="";
        if(isset($id_usuario)){
            $time = time();
            $fechaCompleta=date("Y-m-d H:i:s", $time);
            $v = $this->request->getPost();
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            $estacionamiento = new EstacionamientoTable($this->dbAdapter);
            $data=array("id"=>$v['id'],"date_update"=>$fechaCompleta);
            $estacionamiento->desbloquearEst($data);
            $status="ok";
            
            
       } else{
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

    

}