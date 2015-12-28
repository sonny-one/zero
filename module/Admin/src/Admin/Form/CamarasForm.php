<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class CamarasForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
        //Input type=hidden pk table
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk_cam',
            'attributes' => array(
                'id' => 'id_pk_cam',
                'value' => '0'
            )
        ));
        
        // Radio ///////////////////////////////// Prioridad (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'graban',             
            'options' => array(            
                'value_options' => array(                   
                    array(      
                        'value' => '1',   
                        'label' => 'Si ',                                                                                                 
                        'attributes' => array(  
                            'id'=>'si_graban',
                            'style' => 'margin-right: 4px;'                                                                                                                                                                      
                        ),
                    ),
                    array(      
                        'value' => '0',
                        'label' => ' No',                                                                                                    
                        'attributes' => array(  
                            'id'=>'no_graban',
                            'style' => 'margin: 4px;'                                                                                                                                         
                        ),
                    ),               
                ),
            ),
        ));    
        
        
        //Input Cuenta type=text************camaras
        $this->add(array(
            'type' => 'number',     
            'name' => 'camaras',       
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'nmro_camaras',
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
                'id' => 'reglaslav',
                'rows' => '4',                
                'style' => 'width: max;'
            )
        ));
                 
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendcam',
            'attributes' => array(
                'type' => 'button',
                'id' => 'sendcam',
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