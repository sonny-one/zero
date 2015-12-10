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
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

use Sistema\Model\Entity\SugerenciaTable;
use Sistema\Model\Entity\TipoAsuntoTable;
use Sistema\Model\Entity\UnidadTable;
use Comite\Form\SugerenciaForm;
use Zend\Validator\File\Size;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

use Comite\Form\NotificacionForm;

use Sistema\Model\Entity\General\DbTable;

class ComunicacionController extends AbstractActionController

{
    public function indexAction()

    {                   
        //Cargamos Layout
        $this->layout('layout/comite');
        return new ViewModel();
    }
    
    public function reclamosAction()
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
        $remitente = "Comit�";
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Obtenemos datos POST
        $post = $this->request->getPost();
        if (isset($post['destino'])) {
            //Validamos si es mensaje directo a Dpto            
            if  (isset($post['dpto'])){
                
                //Consultamos datos del dpto
                $dptoMail = new UnidadTable($this->dbAdapter);
                $lista = $dptoMail->getVerResidentesActivos($this->dbAdapter,$post['id_unidad']);
                
                $htmlMarkup=\HtmlCorreo::htmlMensajeDirecto($lista[0]['nombre'],$remitente,$post['textbody']);
                $html = new MimePart($htmlMarkup);
                $html->type = "text/html";
                $body = new MimeMessage();
                $body->setParts(array($html));
                $message = new Message();
                $message->addTo($lista[0]['correo'])
                ->addFrom('notificacion@becheck.cl', 'Notificacion becheck')
                ->setSubject($post['asunto'])
                ->setBody($body);
                $transport = new SendmailTransport();
                $transport->send($message);
                //Retornamos a la vista
                $result = new JsonModel(array(
                //Devolvemos a la Vista
                                    'status'=>'ok',
                                    'descripcion'=>'Se ha enviado correctamente un correo',                    
                    ));   
                //$result->setTerminal(true);                             
                return $result; 
                
            }
            $result = new JsonModel(array(
                //Devolvemos a la Vista
                                    'status'=>'ok',
                                    'descripcion'=>$post,                    
                    ));   
                $result->setTerminal(true);                             
                return $result;                     
	
        }
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
        /*$sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        //Instancias
        $dpto = new UnidadTable($this->dbAdapter);
        $form = new NotificacionForm("form");           
        //Obtenemos combo dptos
        $dptos = $dpto->getDatosActivos(); 
        //Cargamos dptos en formulario
        $form->get('id_unidad')->setAttribute('options' ,$dptos);*/
        
        $plantilla = 'comite';
    
        //return new ViewModel(array('form'=>$form));
        // Se utiliza el dispatch para que se mantenga el nombre de la URL y la variable id se define en el config
        return $this->forward()->dispatch('Admin\Controller\Comunicacion',array('action'=>'circulares','id'=>$plantilla));
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

