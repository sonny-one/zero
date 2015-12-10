<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class CombosProvForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
          
        //Select ///////////////////////////////// Combo Proveedores
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'proveedores',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cproveedores',                
                'required' => 'true'                               
            )
        ));  
        
        //Select ///////////////////////////////// Combo Servicios
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'servicios',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cservicios',                
                'required' => 'true',                               
            )
        ));                 
     
     }

}