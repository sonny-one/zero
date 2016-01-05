<?php

namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class IngresoPagoForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);

        

        //Input ///// /////////////////////////// Tipo_ingreso (TEXT)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'tipo_ingreso',            
            'attributes' => array(                                                   
                'required' => 'true',
                'value' => 'Gasto Comun Unidad'                
            )
        ));
        
        
        //Input ///// /////////////////////////// ORIGEN (TEXT)
        $this->add(array(
            'type' => 'text',
            'name' => 'origen',            
            'attributes' => array(
                'disabled' => 'disabled',
                'class' => 'form-control',
                'id' => 'origen',                
                'required' => 'true',                
            )
        ));
        
        //Input ///////////////////////////////// DESTINO (COMBO) 
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(                
                'id' => 'destino',
                'class' => 'form-control',
                'name' => 'id_fondo',
                'disabled' => 'true',
                'onchange' => 'validaDestino()',                   
                'required' => 'true'                               
            )
        ));  
        
        
        //Radio ///////////////////////////////// PAGO TOTAL (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'radiototal',             
            'options' => array(            
                'value_options' => array(                   
                    array(
                        'label' => 'Pago total', 
                        'value' => 'total',                                                             
                        'attributes' => array(
                            'id' => 'radiototal',
                            'name' => 'tipo_pago',                                                       
                            'onclick' => 'mostrarTotal()'
                        ),
                    ),                
                ),
            ),
        ));
        //Radio ///////////////////////////////// PAGO PARCIAL (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'radioparcial',
            'options' => array(            
                'value_options' => array(
                    array(                                     
                        'label' => 'Pago parcial',
                        'value' => 'parcial',
                        'attributes' => array(
                            'id' => 'radioparcial',                            
                            'name' => 'tipo_pago',                                                      
                            'onclick' => 'mostrarParcial()',                            
                        ),
                    ),                
                ),
            ),
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
                            'onclick' => 'mostrarEfectivo()',                            
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
                            'onclick' => 'mostrarTrans()',                            
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
                            'onclick' => 'mostrarCheque()',                            
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
                            'onclick' => 'mostrarDebito()',                            
                        ),
                    ),                
                ),
            ),
        ));
        
        // - Text - ///////////////////////////////// Monto
        $this->add(array(
            'type' => 'text',
            'name' => 'monto',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'monto',                              
                'onblur' => 'validaMonto()', 
                'required' => 'true'                
            )
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
                'name' => 'banco',
                'id' => 'bancopago',
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
            'name' => 'observacion',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'observacion',
                'rows' => '3',                
                'style' => 'width: max;'
            )
        ));  
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendpago',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendpago',
                'value' => 'Ingresar Pago al sistema',
                'class' => 'btn btn-success'
            ),
        ));
        //Boton Cancelar
        $this->add(array(
            'name' => 'cancel',
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