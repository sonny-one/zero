<?php
namespace Conserje\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class SugerenciaConsultarForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
        
        
        //Select Remitente
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_dpto',
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        

        //Select Asunto
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_tipo_asunto',
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        
        //Boton Enviar
        $this->add(array(
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Buscar',
                'title' => 'Buscar',
                'class' => 'btn btn-success'
            ),
        ));
 
     }
     
}