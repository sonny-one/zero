<?php
namespace Conserje\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Sistema\Model\Entity\General\PersonaTable;
use Sistema\Model\Entity\UnidadTable;
use Sistema\Model\Entity\PersonaDetTable;
use Sistema\Util\SysFnc;

use Zend\Session\Container;


class CfgController extends AbstractActionController

{
    public $dbAdapter;

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
            $r_rut_format = isset($listaRut[$i]['rut'])?number_format($r_rut,-3,"",".")."-".$r_dv:"";
            $datos[$i] = array("id"=>$r_id,"rut"=>$r_rut,"dv"=>$r_dv,"nombre"=>utf8_encode($r_nombre),
            "apellido"=>utf8_encode($r_apellido),"apellido2"=>utf8_encode($r_apellido_2),
            "telefono"=>$r_telefono,"correo"=>$r_correo,"foto"=>$r_foto,"dni"=>$r_dni,"rut_format"=>$r_rut_format);
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
    
    public function regperAction(){
        
        $sid = new Container('base');                                      
        $id_usuario = $sid->offsetGet('id_usuario');
        $dv="";$rut_format="";$status="";$error="";$idPersona="0";
        if(isset($id_usuario)){
            $v = $this->request->getPost();
            
            if(isset($v['nombrep1']) && $v['nombrep1']!=""){
            $rut =  isset($v['rutp1'])?$v['rutp1']:"";
            $rut_format = $rut;
            $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
            $persona = new PersonaTable($this->dbAdapter);
                
            if(!SysFnc::correoValido($v['correop1'])){
                $status="nok";
                $error="Error correo invalido";
            }
            if($rut!="" && $error==""){
                //formato de rut extraemos
                $valores = explode("-",$rut);
                $dv  = $valores[1];
                $rut= str_replace(".","",$valores[0]);
                
                
                $listaRut = $persona->getDatosRut($rut);
                if(count($listaRut)>0){
                    $status="nok";
                    $error="El rut ya existe en el sistema";   
                }
            }
            if($error==""){
                $data= array("tipo"=>$v['tipop1'],"rut"=>$rut,"dv"=>$dv,"dni"=>$v['dnip1'],"nombre"=>$v['nombrep1'],
                "apellido"=>$v['apellidop1'],"apellido2"=>$v['apellido2p1'],"telefono"=>$v['telefonop1'],
                "correo"=>$v['correop1'],"user_create"=>$id_usuario
                );
                
                $idPersona = $persona->nuevaPersona($data);
                $status="ok";
            }
                 
        }else{
            $status="nok";
            $error="Nombre de la persona esta vacio";
            $idPersona="-1";
            
            }
        }else{
            $status="nok";
            $error="usuario no encontrado";
            $idPersona="-1";
        }
         
         return new JsonModel(
                        array(
                        'status'=>$status,
                        'error'=>$error,
                        'idpersona'=>$idPersona,
                        'dv'=>$dv,
                        'rutformat'=>$rut_format
                        )
                        );  
    }
    
    
    
       

    

}