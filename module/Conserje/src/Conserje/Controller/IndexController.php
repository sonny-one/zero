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

        return new ViewModel(array("mensaje"=>$mensaje));
    }
    
    public function getdptoAction()
    {            
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
    
        //Obtenemos datos POST
        $lista = $this->request->getPost();
        $dpto = new UnidadTable($this->dbAdapter);
        $unidad = $dpto->getIdUnidad($lista['dpto']);
        
        
        return new JsonModel(array('unidad'=>$unidad));
    }
}
