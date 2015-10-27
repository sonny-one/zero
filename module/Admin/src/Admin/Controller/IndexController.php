<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
 
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

use Sistema\Model\Entity\General\DbTable;

class IndexController extends AbstractActionController

{
    public function indexAction()

    {                   
        //Cargamos Layout
        $this->layout('layout/admin');
        //Instancias
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $sid  = new Container('base');        
        //Obtenemos Datos de sesion        
        $nombre = $sid->offsetGet('nombreComercial');
        $dbNombre = $sid->offsetGet('dbNombre');        
        //Buscamos direccion del condominio para mostrar                
        
        $valores = array(
          'agua' => "804369",
          'luz' => "2854633",
          'mantenciones' => "854666",
          'remuneraciones' => "6456997",
          'insumos' => "1269322",
          );          
          
        return new ViewModel(array("nombre"=>$nombre,"direccion"=>$direccion,'valores'=>$valores));
    }
}

