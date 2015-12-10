<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class AscensorForm extends Form
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
        
        //Input Cuenta type=text************Fabricante
        $this->add(array(
            'type' => 'text',            
            'attributes' => array(
                'name' => 'fabricante',
                'class' => 'form-control',
                'id' => 'fabricante',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
       //Input Cuenta type=text************modelo
        $this->add(array(
            'type' => 'text',
            'name' => 'modelo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'modelo',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************capacidad
        $this->add(array(
            'type' => 'text',
            'name' => 'capacidad',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'capacidad',
                'placeholder'=>'Personas',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************Año Fabricacion
        $this->add(array(
            'type' => 'text',
            'name' => 'anio',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'anio',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
                //Input Cuenta type=text************detalle
        $this->add(array(
            'type' => 'textarea',
            'name' => 'detalle',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'detalle',
                'rows' => '4',                
                'style' => 'width: 50%;'
            )
        ));
        
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendasc',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendasc',
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