<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class EdificacionForm extends Form
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
        
        //Input Cuenta type=text************piso
        $this->add(array(
            'type' => 'text',
            'name' => 'piso',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'piso',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
       //Input Cuenta type=text************departamento
        $this->add(array(
            'type' => 'text',
            'name' => 'departamento',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'departamento',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************torre
        $this->add(array(
            'type' => 'text',
            'name' => 'torre',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'torre',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************subterraneo
        $this->add(array(
            'type' => 'text',
            'name' => 'subterraneo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'subterraneo',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************est_visita
        $this->add(array(
            'type' => 'text',
            'name' => 'est_visita',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'est_visita',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        
         //Input Cuenta type=text************ascensor
        $this->add(array(
            'type' => 'text',
            'name' => 'ascensor',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'ascensor',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
         //Input Cuenta type=text************quincho
        $this->add(array(
            'type' => 'text',
            'name' => 'quincho',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'quincho',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
                 //Input Cuenta type=text************salon
        $this->add(array(
            'type' => 'text',
            'name' => 'salon',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'salon',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
                 //Input Cuenta type=text************piscina
        $this->add(array(
            'type' => 'text',
            'name' => 'piscina',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'piscina',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        
                 //Input Cuenta type=text************gimnasio
        $this->add(array(
            'type' => 'text',
            'name' => 'gimnasio',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'gimasio',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        
                 //Input Cuenta type=text************acceso
        $this->add(array(
            'type' => 'text',
            'name' => 'acceso',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'acceso',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
                 //Input Cuenta type=text************lavanderia
        $this->add(array(
            'type' => 'text',
            'name' => 'lavanderia',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'lavanderia',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        
        //Boton Enviar
        $this->add(array(
            'name' => 'send2',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'send2',
                'value' => 'Guardar',
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