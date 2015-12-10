<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Conserje\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

use Sistema\Model\Entity\UnidadTable;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        
        
        $this->layout('layout/conserje');
         $this->layout()->inicio = "active";
         $mensaje="";
        return new ViewModel(array("mensaje"=>$mensaje));
    }
    
    public function getdptoAction()
    {            
        /*$sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
    
        //Obtenemos datos POST
        $lista = $this->request->getPost();
        $dpto = new UnidadTable($this->dbAdapter);
        $unidad = $dpto->getIdUnidad($lista['dpto']);
        
          
        $result = new ViewModel(array('unidad'=>$unidad));
        $result->setTerminal(true);
        return $result*/
        $status="nok";$error="";
        $msj="";
        
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        //$id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        $id_usuario = $sid->offsetGet('id_usuario');
        $parametro = $this->request->getPost();
        if(isset($id_usuario)&& !empty($parametro['dpto'])){
            
                    $dpto = new UnidadTable($this->dbAdapter);
        $lista = $dpto->getListarDptoByNombre($this->dbAdapter,$parametro['dpto']);
        $nombre = "";$titular="";$contacto="";$condicion="";$tabla="";
        
        if(count($lista)>0){
            $status="ok";
            $tabla="<table class='table table-hover'><thead><tr><th>Nombres</th><th>Contacto</th><th></th></tr></thead><tbody>";
            $nombre=$lista[0]['dpto'];
            for($i=0;$i<count($lista);$i++){
                if($lista[$i]['titular']=="1"){
                    $titular = isset($lista[$i]['nombre'])?$lista[$i]['nombre']:"";
                    if(isset($lista[$i]['condicion'])){
                        $condicion = $lista[$i]['condicion']=="A"?"Arrendatario":"Copropetario";
                    }
                    $contacto = isset($lista[$i]['contacto'])?$lista[$i]['contacto']:"";
                }else{
                   $tabla=$tabla."<tr><td>".$lista[$i]['nombre']."</td><td>".$lista[$i]['contacto']."</td><td>".$lista[$i]['condicion']."</td></tr>";
                }
            }
            $tabla=$tabla."</tbody></table>";
        }else{
            $status="nok";
            $error="No hay informacion para el departamento: ".$parametro['dpto'];
        }

            
            
            
        }else{
            $error="La sesion ha finalizado, vuelve a conectarse al sistema";
        }
      
        
        $datos = array('status'=>$status,
                        'error'=>$error,
                        'message'=>$msj,
                        'nombre'=>$nombre,
                        'titular'=>$titular,
                        'contacto'=>$contacto,
                        'condicion'=>$condicion,
                        'tabla'=>$tabla
        );
        
        $result = new JsonModel($datos); 
        
        return $result; 
        
    }
}
