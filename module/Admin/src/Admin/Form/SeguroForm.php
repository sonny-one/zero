<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class SeguroForm extends Form
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
        
         //Input Cuenta type=file*******FILE*****poliza
        $this->add(array(
    'type' => 'Zend\Form\Element\File',
    'name' => 'filepoliza',
    'attributes' => array(
        'multiple' => 'multiple',
        'id' => 'filepoliza',
            )
        ));
        
      //Input Cuenta type=text************poliza 
        $this->add(array(
            'type' => 'text',     
            'name' => 'poliza',       
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'poliza',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
       //Input Cuenta type=text************riesgo
        $this->add(array(
            'type' => 'text',
            'name' => 'riesgo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'riesgo',                
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************prima
        $this->add(array(
            'type' => 'text',
            'name' => 'valor_prima',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'valor_prima',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************cuotas
        $this->add(array(
            'type' => 'text',
            'name' => 'cuotas',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cuotas',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************vigencia
        $this->add(array(
            'type' => 'text',
            'name' => 'vigencia',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'vigencia',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));

        //Input Cuenta type=text************vigenciafin
        $this->add(array(
            'type' => 'text',
            'name' => 'vigenciafin',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'vigenciafin',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));   

        
                        //Input Cuenta type=text*********detalle
        $this->add(array(
            'type' => 'textarea',
            'name' => 'detalle',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'detalle',
                'rows' => '3',                
                'style' => 'width: 50%;'
            )
        ));
                 
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendseg',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendseg',
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