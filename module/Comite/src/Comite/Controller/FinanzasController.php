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

use Sistema\Model\Entity\SugerenciaTable;
use Sistema\Model\Entity\TipoAsuntoTable;
use Sistema\Model\Entity\UnidadTable;
use Conserje\Form\SugerenciaForm;
use Zend\Validator\File\Size;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

use Conserje\Form\NotificacionForm;

use Sistema\Model\Entity\General\DbTable;

class FinanzasController extends AbstractActionController

{
    public function indexAction()

    {                   
        //Cargamos Layout
        $this->layout('layout/comite');
        return new ViewModel();
    }
    
    public function balanceAction()
    {                   
        //Conectamos a BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        //Instancias
                 
                 
        //Obtenemos 
        $form="";
     
        //Retornamos a la vista
        $this->layout('layout/comite');
    
        return new ViewModel(array('form'=>$form));
    }
    
    public function notificarAction()

    {                   
        //Conectamos a BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        //Instancias
        $dpto = new UnidadTable($this->dbAdapter);
        $form = new NotificacionForm("form");           
        //Obtenemos combo dptos
        $dptos = $dpto->getDatosActivos(); 
        //Cargamos dptos en formulario
        $form->get('id_unidad')->setAttribute('options' ,$dptos);
        
        $this->layout('layout/comite');
    
        return new ViewModel(array('form'=>$form));
    }
    
    public function circularAction()
    {                   
        //Conectamos a BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        //Instancias
        $dpto = new UnidadTable($this->dbAdapter);
        $form = new NotificacionForm("form");           
        //Obtenemos combo dptos
        $dptos = $dpto->getDatosActivos(); 
        //Cargamos dptos en formulario
        $form->get('id_unidad')->setAttribute('options' ,$dptos);
        
        $this->layout('layout/comite');
    
        return new ViewModel(array('form'=>$form));
    }
    
        public function asambleaAction()
    {                   
        //Conectamos a BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        //Instancias
                 
                 
        //Obtenemos 
        $form="";
     
        //Retornamos a la vista
        $this->layout('layout/comite');
    
        return new ViewModel(array('form'=>$form));
    }
    
    
}

