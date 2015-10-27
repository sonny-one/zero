<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Sistema\Model\Entity\General\SessionTable;
use Sistema\Model\Entity\General\UsuarioTable;

class IndexController extends AbstractActionController
{
    
    public $dbAdapter;
    public function indexAction()
    {
        
        $data = $this->request->getPost();
        $mensaje = "Hola Mundo desde Zend Framework 2";
        $this->layout('layout/layout');
         $this->layout()->inicio = "active";

        return new ViewModel(array("mensaje"=>$mensaje));
    }
    public function dbAction()
    {
        
        $sid = new Container('base');
        $this->layout('layout/admin');
        if ($sid->offsetExists('idSession')){
             $idSession = $sid->offsetGet('idSession');
             $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
             $tsession = new SessionTable($this->dbAdapter);
             $tsession->eliminarSesion($idSession);
        }
        
        
        return new ViewModel();
    }
    public function dbparamAction(){                            
        
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $usuario = new UsuarioTable($this->dbAdapter);
        $tsession = new SessionTable($this->dbAdapter);                               
        
        $id_db = $this->params()->fromRoute('id', 0);
        $sid = new Container('base');
        
        $dbParam = $sid->offsetGet('dbParam');
        
        for($i=0;$i<count($dbParam);$i++){
            
            if ($id_db==$dbParam[$i]['id']){
                $id_perfil = $dbParam[$i]['id_perfil'];
                $nro_session = $dbParam[$i]['nro_session'];
                $db_nombre = $dbParam[$i]['nombre_db'];                
                $nombreComercial = $dbParam[$i]['nombre'];
                $perfil = $dbParam[$i]['perfil'];
                break;
            }
        }
        $id_usuario = $sid->offsetGet('id_usuario');
        
        $nroSessionDB = count($tsession->obtenetSesion($id_usuario,$id_db));
        
         if ($nro_session>0 && $nroSessionDB >= $nro_session){
             $sid->getManager()->getStorage()->clear();
            if(isset($_COOKIE['usuario']))
            {
                unset($_COOKIE['usuario']);
            }
             if(isset($_COOKIE['password']))
            {
                unset($_COOKIE['password']);
            }
               //return $this->forward()->dispatch('Application\Controller\Login',array('action'=>'index','id'=>4));
               return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/application/login/index/4');
         }
                    
        
        $sid->offsetSet('dbNombre',$db_nombre);
        $sid->offsetSet('nombreComercial',$nombreComercial);
        $sid->offsetSet('id_db',$id_db); 
        $sid->offsetSet('perfil',$perfil);
        
         $valores = array('id_usuario'=>$id_usuario,'id_db'=>$id_db,'ip_cliente'=>$_SERVER['REMOTE_ADDR'],'port_cliente'=>$_SERVER['REMOTE_PORT']);
         $sid->offsetSet('idSession',$tsession->crearSesion($valores));
        
        //Mapeamos la base de datos
            
            $modulo = $usuario->getModulo($this->dbAdapter,$id_perfil);
            $sid->offsetSet('modulo', $modulo);
           
             if(count($modulo) > 1){
                $urlHome = 'application';
             }else{
                $urlHome = $modulo[0]['url'];
             }
             $sid->offsetSet('urlHome',$urlHome);
             
             return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/'.$urlHome);
                             
        
        
        
        //return new ViewModel();
    }
        public function cambioclaveAction()
    {

        
         return new ViewModel();
        //return $this->forward()->dispatch('Application\Controller\Login',array('action'=>'index','id'=>3));
        
       
    } 
    
}
