<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class CicloForm extends Form

{

     public function __construct($name = null)

     {
        parent::__construct($name);        

        // Hidden ////////////////////////////// id_pk
        $this->add(array(
            'name' => 'id_pk',
            'type'  => 'hidden',
            'attributes' => array(                
                'value' => '0',                
            ),        
        ));
                

        // Number ////////////////////////////// Dia Cierre
        $this->add(array(
            'type'  => 'number',
            'name' => 'dia',
            'attributes' => array(   
                'min' => '1',
                'max' => '28',             
                'class' => 'form-control',
                'required' =>'true',
            ),        
        )); 
        
        // Time //////////////////////////// Hora Cierre
        $this->add(array(
            'type' => 'time',
            'name' => 'hora',
            'attributes' => array(               
                'class' => 'form-control',
                'required' =>'true',
            ),        
            )); 
        
        //Boton Enviar

        $this->add(array(
            'name' => 'sendciclo',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Guardar',                
                'title' => 'Enviar',
                'class' => 'btn btn-success'
            ),
        ));

     

     }



}