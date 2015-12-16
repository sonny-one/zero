<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class EgresoForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
          
        //Select ///////////////////////////////// Combo Tipo de Egreso
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipo_egreso',
            'attributes' => array(
                'onchange' => 'paso2()',
                'class' => 'form-control',
                'id' => 'tipo_egreso',                
                'required' => 'true'                               
            )
        ));  
        
        //Select ///////////////////////////////// Combo Proveedores
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'proveedores',
            'attributes' => array(
                'onchange' => 'paso3()',
                'class' => 'form-control',
                'id' => 'combo_proveedores',                
                'required' => 'true'                               
            )
        ));  
        
        //Button ///////////////////////////////// Ir a Pagar
        $this->add(array(
            'name' => 'enviar',
            'attributes' => array(                                
                'onclick' => 'modalPago()',
                'type' => 'button',
                'value' => 'Ir a pagar',
                'title' => 'Enviar',
                'data-toggle'=>'modal',
                'data-target'=>'#pagoprov',
                'class' => 'btn btn-success',
            ),
        ));
        
              
     
     }

}