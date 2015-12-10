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
                                    
            $this->layout('layout/usuario');         

            return new ViewModel(array('reclamo'=>$reclamo3));
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
                                    
            $this->layout('layout/usuario');         

            return new ViewModel(array('reclamo'=>$reclamo3));
    }
}
