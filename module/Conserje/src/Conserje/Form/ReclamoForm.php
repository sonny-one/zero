<?php
namespace Conserje\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class ReclamoForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
        //Input type=hidden pk table
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk',
            'attributes' => array(
                'value' => '0'
            )
        ));
        
        //Select Remitente
        $this->add(array(
            'name' => 'id_dpto',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'readonly' => 'true'
            ),
        ));
        
        //Input type=text receptor
        $this->add(array(
            'name' => 'receptor',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'value' => 'Administrador',
                'readonly' => 'true'
            ),
        ));

        //Select Asunto
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_tipo_asunto',
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        
        //Input type=textArea descripcion <textarea name="area3" style="width: 270px; height: 150px;"></textarea>
        $this->add(array(
            'type' => 'textarea',
            'name' => 'descripcion',                    
            'attributes' => array(
                // 'class' => 'form-control',
                'style'=>'width: 270px; height: 150px;'            
            ),
        ));        
        
        //Boton Enviar
        $this->add(array(
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
                'title' => 'Enviar',
                'class' => 'btn btn-success'
            ),
        ));
        //Boton Cancelar
        $this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Cancelar',
                'title' => 'Cancelar',
                'class' => 'btn btn-danger'
            ),
        ));        
     
     }

}