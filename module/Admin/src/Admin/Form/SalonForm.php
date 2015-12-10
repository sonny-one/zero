<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class SalonForm extends Form
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
        
        //Input Cuenta type=text************Nombre
        $this->add(array(
            'type' => 'text',            
            'attributes' => array(
                'name' => 'nombre',
                'class' => 'form-control',
                'id' => 'nombre',
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
        
        //Input Cuenta type=text************valor
        $this->add(array(
            'type' => 'text',
            'name' => 'valor',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'valor',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************garantia
        $this->add(array(
            'type' => 'text',
            'name' => 'garantia',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'garantia',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************horario1
        $this->add(array(
            'type' => 'text',
            'name' => 'horario1',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'horario1',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));

        //Input Cuenta type=text************horario1fin
        $this->add(array(
            'type' => 'text',
            'name' => 'horario1fin',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'horario1fin',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));   
            
        //Input Cuenta type=text************horario2
        $this->add(array(
            'type' => 'text',
            'name' => 'horario2',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'horario2',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));

        //Input Cuenta type=text************horario2fin
        $this->add(array(
            'type' => 'text',
            'name' => 'horario2fin',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'horario2fin',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                        //Input Cuenta type=text************reglas
        $this->add(array(
            'type' => 'textarea',
            'name' => 'reglas',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'reglas',
                'rows' => '4',                
                'style' => 'width: 50%;'
            )
        ));
                 
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendsalon',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendsalon',
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