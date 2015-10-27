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

class ClubController extends AbstractActionController
{
    public function indexAction()
    {
        
        $data = $this->request->getPost();
        $mensaje = "Hola Mundo desde Zend Framework 2";
        $titulo = "Club de Beneficios Be check";
        $this->layout('layout/usuario');
         $this->layout()->inicio = "active";

        return new ViewModel(array("mensaje"=>$mensaje, "titulo"=>$titulo));
    }
}
