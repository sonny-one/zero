<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GcomunesController extends AbstractActionController
{
    public function indexAction()
    {
        
        $data = $this->request->getPost();
        $titulo = "Consultar";
        $this->layout('layout/usuario');
         $this->layout()->inicio = "active";

        return new ViewModel(array('titulo'=>$titulo));
    }
}
