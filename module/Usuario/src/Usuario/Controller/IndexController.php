<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\Model;
use Zend\Db\Adapter\Adapter;

use Zend\Session\Container;

use Sistema\Model\Entity\ReclamoTable;

class IndexController extends AbstractActionController
{
    public function indexAction()
    { 
        $this->layout('layout/usuario');
    }
    
    
    public function miunidadAction()
    {        
        $result = new ViewModel();
        $result->setTerminal(true);
       
        return $result;       
    }
    
    public function micondominioAction()
    { 
       
            //Instancias
            $sid = new Container('base');            
            //Obtenemos datos de sesion                  
              $db_name = $sid->offsetGet('dbNombre');
            //Conectamos a BBDD Condominio
            $this->dbAdapter = $this->getServiceLocator()->get($db_name); 
            
            //Obtenemos datos POST
            $data = $this->request->getPost();
            
            //Tablas
            $reclamo = new ReclamoTable($this->dbAdapter);            
            $info['cantidad'] = $reclamo->getCantReclamo();
                                    
        //    $this->layout('layout/usuario');         
 
        
        $result = new ViewModel($info);
        $result->setTerminal(true);
       
        return $result;      
    }
    
    public function reclamoAction()
    {
            
            //Instancias
            $sid = new Container('base');            
            //Obtenemos datos de sesion                  
              $db_name = $sid->offsetGet('dbNombre');
            //Conectamos a BBDD Condominio
            $this->dbAdapter = $this->getServiceLocator()->get($db_name); 
            
            //Obtenemos datos POST
            $data = $this->request->getPost();
            
            //Tablas
            $reclamo = new ReclamoTable($this->dbAdapter);            
            $reclamo3 = $reclamo->getReclamo($id);
                                    
        //    $this->layout('layout/usuario');         

            return new ViewModel(array('reclamo'=>$reclamo3));
    }
}
