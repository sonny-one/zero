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


class NotificacionController extends AbstractActionController

{

    public $dbAdapter;

    public function indexAction()
    {
        $this->layout('layout/conserje');
        $this->layout()->sugerencia = "active";
        $this->layout()->sugerenciaprincipal = "active";
        return new ViewModel();
    }
    
    
    public function nuevaAction()
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

    }

}