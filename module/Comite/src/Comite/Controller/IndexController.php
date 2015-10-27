<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
 
namespace Comite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

use Sistema\Model\Entity\General\DbTable;

class IndexController extends AbstractActionController

{
    public function indexAction()

    {                   
        //Cargamos Layout
        $this->layout('layout/comite');
        return new ViewModel();
    }
}

