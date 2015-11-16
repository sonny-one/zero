<?php
namespace Conserje\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

use Sistema\Model\Entity\SugerenciaTable;
use Sistema\Model\Entity\TipoAsuntoTable;
use Sistema\Model\Entity\UnidadTable;
use Conserje\Form\SugerenciaForm;
use Zend\Session\Container;
use Zend\Validator\File\Size;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

use Conserje\Form\NotificacionForm;

use Sistema\Util\SysFnc;


class NotificacionController extends AbstractActionController

{

    public $dbAdapter;

    public function indexAction()
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
        
        $this->layout('layout/conserje');
        $result = new ViewModel(array('rsptaOK'=>SysFnc::rspOK(),'form'=>$form));
         //$result->setTerminal(true);
         return $result;
    }
        
   /* public function nuevaAction()
    {                
       $post = $this->request->getPost();       
       if ($post['flag'] == "comite"){    
          $btn = array(
                'tab1'  => 'mdirecto',
                'faboton1' => 'fa-paper-plane',
                'txtboton1' => 'Mensaje Directo',
                'tab2'  => '',
                'faboton2' => '',
                'txtboton2' => '',
                'tab3'  => '',
                'faboton3' => '',
                'txtboton3' => '',
           );
            $texto = "Se enviar&aacute; un correo electr&oacute;nico a <strong>cada integrante del comit&eacute;</strong> informando lo que Ud seleccione a continuaci&oacute;n";                
       }
       if ($post['flag'] == "comunidad"){        
            $texto = "Informa a los residentes de alguna <strong>situaci&oacute;n importante</strong>, cada integrante de la comunidad recibir&aacute; tu notificaci&oacute;n";                
       }      
       if ($post['flag'] == "administrador  "){                
       }                                     
        $result = new ViewModel(array('flag'=>$post['flag'],'texto'=>$texto, 'btn'=>$btn));
        $result->setTerminal(true);     
        return $result;

    }*/
    
    public function enviarAction()
    {   
        //Obtenemos datos POST
        $post = $this->request->getPost();
        //Conectamos a BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Tablas
        $dpto = new UnidadTable($this->dbAdapter);
         $lista = $dpto->getVerResidentesActivos($this->dbAdapter,$post['id_unidad']);
        //Validamos destinatario
        if(isset($post['dpto'])){                
        $lista = $dpto->getVerResidentesActivos($this->dbAdapter,$post['id_unidad']);                                
            
            $html = new MimePart($post['textbody']);
            $html->type = "text/html";
            $body = new MimeMessage();
            $body->setParts(array($html));
            $message = new Message();
            $message->addTo($lista[0]['correo'])
            ->addFrom('contacto@becheck.cl', 'Sistema be check')
            ->setSubject('Notificacion Conserjeria en Linea')
            ->setBody($body);
            $transport = new SendmailTransport();
            $transport->send($message);
            
        }else{
            
            
        }
        
        
        $result = new JsonModel(array('status'=>'ok'));
         //$result->setTerminal(true);
         return $result;
    }

}