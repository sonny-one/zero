<?php

namespace Comite\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class NotificacionForm extends Form
{
     public function __construct($name = null)
     {
        parent::__construct($name);


        $this->add(array(
        'type' => 'Zend\Form\Element\MultiCheckbox',
        'name' => 'destino',
        'options' => array(
            'label' => 'Selecciona un Destinatario',
            'value_options' => array(
               array(
                   'value' => 'comite',
                   'label' => ' Comite',
                   'selected' => false,
                   'disabled' => false,
                   'attributes' => array(
                       'id'=>'chk_comite',
                       'onclick' => 'checkChk()',
                   ),
               ),
               array(
                   'value' => 'admin',
                   'label' => ' Administrador',                   
                   'attributes' => array(
                       'id'=>'chk_admin',
                       'onclick' => 'checkChk()',
                   ),
                   'label_attributes' => array(
                       'style' => 'padding: 5px;',
                   ),
               ),
               array(
                   'value' => 'comunidad',
                   'label' => ' Comunidad',
                   'attributes' => array(
                       'id'=>'chk_comuni',
                       'onclick' => 'checkChk()',
                   ),
                   'label_attributes' => array(
                       'style' => 'padding: 5px;',
                   ),
               ),            
            ),
            ),
         ));
        
        // Radio ///////////////////////////////// Destinatario (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'dpto',             
            'options' => array(            
                'value_options' => array(                   
                    array(                                                                                                          
                        'attributes' => array(  
                            'id'=>'radio_dpto',                                                                                                             
                            'onclick' => 'checkDpto()'
                        ),
                    ),                
                ),
            ),
        ));
        // Select ///////////////////////////////// Dptos 
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_unidad',
            'attributes' => array(
                'id' => 'combo_dpto',   
                'disabled' => true,                
                'class' => 'form-control hidden'
            )

        ));
        
        // text ///////////////////////////////// Asunto 
        $this->add(array(
            'name' => 'asunto',
            'attributes' => array(                
                'type' => 'text',
                'class' => 'form-control'
                
            ),

        ));  
        
        // Radio ///////////////////////////////// Prioridad (Urgente)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'prioridad',             
            'options' => array(            
                'value_options' => array(                   
                    array(                         
                        'value' => 'urgente',                                                             
                        'attributes' => array(                            
                            'name' => 'prioridad',                                                       
                        ),
                    ),                
                ),
            ),
        ));
        
        // Radio ///////////////////////////////// Prioridad (Normal)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'prioridad',             
            'options' => array(            
                'value_options' => array(                   
                    array(                        
                        'value' => 'normal',                                                             
                        'attributes' => array(                            
                            'name' => 'prioridad',                                                       
                        ),
                    ),                
                ),
            ),
        ));
        
       /* //Boton Enviar
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
        ));    */    

     }

}