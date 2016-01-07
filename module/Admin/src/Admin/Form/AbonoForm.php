<?php

namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class AbonoForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);


        //Input //////////HIDDEN//////HIDDEN///// Tipo_ingreso (TEXT)
        $this->add(array('type' => 'hidden','name' => 'id_unidad'));
        
        
        //Input ///////////////////////////////// UNIDAD (TEXT)
        $this->add(array(
            'type' => 'text',
            'name' => 'nombre_unidad',            
            'attributes' => array(
                'disabled' => 'disabled',
                'class' => 'form-control',
                'id' => 'nombre_unidad',                                               
            )
        ));      
        
                
        // - Text - ///////////////////////////////// Monto
        $this->add(array(
            'type' => 'text',
            'name' => 'monto_abono',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'monto_abono',                              
                'onkeypress' => 'return isNumber(event)', 
                'onkeyup' => 'formatMonto()',
                'required' => 'true',
                'placeholder' => 'Ingresa el monto'                
            )
        ));
        
        
        //Radio ///////////////////////////////// EFECTIVO (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'efectivo',
            'options' => array(            
                'value_options' => array(
                    array(                                     
                        'label' => 'Efectivo',
                        'value' => 'efectivo',
                        'attributes' => array(                            
                            'name' => 'forma_pago',
                            'id' => 'efectivo',                            
                            'onclick' => 'mostrarEfectivoAbono()',                            
                        ),
                    ),                
                ),
            ),
        ));
        //Radio ///////////////////////////////// TRANSFERENCIA (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'transferencia',
            'options' => array(            
                'value_options' => array(
                    array(                                     
                        'label' => 'Transferencia',
                        'value' => 'transferencia',
                        'attributes' => array(                            
                            'name' => 'forma_pago',                            
                            'onclick' => 'mostrarTransAbono()',                            
                        ),
                    ),                
                ),
            ),
        ));
        //Radio ///////////////////////////////// CHEQUE (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'cheque',
            'options' => array(            
                'value_options' => array(
                    array(                                     
                        'label' => 'Cheque',
                        'value' => 'cheque',
                        'attributes' => array(                            
                            'name' => 'forma_pago',                            
                            'onclick' => 'mostrarChequeAbono()',                            
                        ),
                    ),                
                ),
            ),
        ));
        //Radio ///////////////////////////////// DEBITO/CREDITO (Radio)  
        $this->add(array(

            'type' => 'Zend\Form\Element\Radio',
            'name' => 'debito',
            'options' => array(            
                'value_options' => array(
                    array(                                     
                        'label' => 'Debito/Credito',
                        'value' => 'debito/credito',
                        'attributes' => array(                            
                            'name' => 'forma_pago',                            
                            'onclick' => 'mostrarDebitoAbono()',                            
                        ),
                    ),                
                ),
            ),
        ));

        // - Date - ///////////////////////////////// Fecha Pago 
        $this->add(array(
            'type' => 'date',
            'name' => 'fecha',
            'attributes' => array(                
                'id' => 'fecha_pago',
                'class' => 'form-control',
                'required' => 'true',                           
            )
        )); 
        
        // - Select - //////////////////////////// Banco 
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'name' => 'banco_abono',
                'id' => 'banco_abono',
                'class' => 'form-control',
                'required' => 'true',                                
            )
        )); 
        
        // - Text - ///////////////////////////////// N° Operacion 
        $this->add(array(
            'type' => 'text',
            'name' => 'nmrooperacion',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nmrooperacion',
                'onblur' => 'checkMonto()',                
                'required' => 'true'                
            )
        ));
        
        // - Text - ///////////////////////////////// N° Cheque 
        $this->add(array(
            'type' => 'text',
            'name' => 'nmrocheque',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nmrocheque',                              
                'required' => 'true'                
            )
        ));    
        
        // - TextArea - ///////////////////////////////// Observacion
        $this->add(array(
            'type' => 'textarea',
            'name' => 'comentario_abono',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui...',
                'id' => 'comentario_abono',
                'rows' => '3',                
                'style' => 'width: max;'
            )
        ));  
        
        //Boton Enviar
        $this->add(array(
            'name' => 'send_abono',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'send_abono',
                'value' => 'Ingresar Abono al sistema',
                'class' => 'btn btn-success'
            ),
        ));
        //Boton Cancelar
        $this->add(array(
            'name' => 'cancel_abono',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancelar',
                'data-dismiss' => 'modal',
                'title' => 'Cancelar',
                'class' => 'btn btn-danger'
            ),
        ));        
     
     }

}