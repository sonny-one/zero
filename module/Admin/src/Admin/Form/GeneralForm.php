<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class GeneralForm extends Form
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
        
        //Input type=hidden tipo persona
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'tipo',
            'attributes' => array(
                'value' => 'juridica'
            )
        ));
        
        //Input type=text ********Nombre Comunidad
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'nombre',
                'id' => 'nombre',
                'class' => 'form-control',
                'required' => 'true',                
                'style' => 'max-width: 80%;'             
            )
        ));

        

        //Input type=text ****************RUT
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'rut',
                'id' => 'rutgral',
                'class' => 'form-control',
                'required' => 'true',                
                'style' => 'max-width: 80%;',
                'data-toggle'=> 'popover',                
                'data-placement'=>'right'              
            )
        ));
        
        //Input direccion type=text ********Direccion Comunidad
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'direccion',
                'id' => 'direccion',
                'class' => 'form-control',
                 'required' => 'true',
                 'style' => 'max-width: 80%;'
            ),
        ));

        //Input Ciudad type=text ********Ciudad 
        $this->add(array(
            'type' => 'text',
            'name' => 'ciudad',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'ciudad',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
                //Input Ciudad type=text ********Pais 
        $this->add(array(
            'type' => 'text',
            'name' => 'pais',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'pais',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));


         //Input type=text ****************Telefono Administrador

        $this->add(array(

            'type' => 'text',
            'attributes' => array(
                'name' => 'telefono',
                'id' => 'telefono',
                'class' => 'form-control',
                'required' => 'true',                
                'style' => 'max-width: 80%;'             
            )
        ));
        
        //Input type=text ****************Telefono Conserjeria
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'telefono2',
                'id' => 'telefono2',
                'class' => 'form-control',
                'required' => 'true',                
                'style' => 'max-width: 80%;'             
            )
        ));
        
        //Input type=email **************** Mail Comunidad
        $this->add(array(
            'type' => 'email',
            'attributes' => array(
                'name' => 'emailcom',
                'id' => 'emailcom',
                'class' => 'form-control',
                'required' => 'true',                
                'style' => 'max-width: 80%;'             
            )
        ));
        
        //Input type=email **************** Mail Gastos Comunes
        $this->add(array(
            'type' => 'email',
            'attributes' => array(
                'name' => 'emailgc',
                'id' => 'emailgc',
                'class' => 'form-control',
                'required' => 'true',                
                'style' => 'max-width: 80%;'             
            )
        ));
        
        //Input type=text ****************Pagina WEB
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'web',
                'id' => 'web',
                'class' => 'form-control',
                'required' => 'true',                
                'style' => 'max-width: 80%;'             
            )
        ));
        
        //Boton Enviar
        $this->add(array(
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendgral',
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