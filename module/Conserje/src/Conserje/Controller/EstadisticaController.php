<?php

namespace Conserje\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EstadisticaController extends AbstractActionController
{
    
    public function indexAction()
    {
        $this->layout('layout/conserje');
         $this->layout()->estadistica = "active";
        return new ViewModel();
    }

    
}