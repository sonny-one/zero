<?php

namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class PagoProvForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);

        

        //Input ///// /////////////////////////// Tipo_ingreso (TEXT)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'tipo_egreso',            
            'attributes' => array(                                                   
                'required' => 'true',
                'value' => 'Pago Proveedor'                
            )
        ));
        
        //Input ///// /////////////////////////// id_prov (TEXT)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'id_prov',            
            'attributes' => array(                                                   
                'required' => 'true'               
            )
        ));
        
        //Input ///// /////////////////////////// concepto egreso (TEXT)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'concepto',            
            'attributes' => array(                                                   
                'required' => 'true'               
            )
        ));
        
        //Input //////////////////////////////// ORIGEN (COMBO)
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'origen',            
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'origen',                
                'required' => 'true',                
            )
        ));
        
        //Input ///////////////////////////////// DESTINO (TEXT) 
        $this->add(array(
            'type' => 'text',             
            'attributes' => array(                
                'id' => 'destino',
                'name' => 'destino',
                'disabled' => 'disabled',
                'class' => 'form-control',                                                 
                'required' => 'true'                               
            )
        ));  
        
       // - Text - ///////////////////////////////// Monto
        $this->add(array(
            'type' => 'text',
            'name' => 'monto',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'monto',                              
                'onkeyup' => 'formatMonto()',
                'onkeypress'=>'return isNumber(event);', 
                'required' => 'true'                
            )
        ));
        
        // - Text - ///////////////////////////////// MontoCuota
        $this->add(array(
            'type' => 'text',
            'name' => 'montocuota',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'montocuota',                              
                'onkeyup' => 'formatMonto2()',
                'onkeypress'=>'return isNumber(event);', 
                'required' => 'true'                
            )
        ));
        
        
        //Input //////////////////////////////// Cantidad Cuotas (COMBO)
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'cuotas',            
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'cuotas',
                'disabled' => 'disabled',   
                'onchange' => 'calculaCuota()',            
                'required' => 'true',
                'options' => array(
                    '0'=>'2',
                    '1'=>'3',
                    '2'=>'4',
                    '3'=>'5',
                    '4'=>'6',
                    '5'=>'7',
                    '6'=>'8',
                    '7'=>'9',
                    '8'=>'10',
                    '9'=>'11',
                    '10'=>'12',                                        
                )                
            )
        ));
        //Radio ///////////////////////////////// PAGO TOTAL (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'radiototal',             
            'options' => array(            
                'value_options' => array(                   
                    array(
                        'label' => 'Total', 
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
        //Radio ///////////////////////////////// PAGO CUOTAS (Radio)  
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'radiocuotas',
            'options' => array(            
                'value_options' => array(
                    array(                                     
                        'label' => 'Cuotas',
                        'value' => 'cuotas',
                        'attributes' => array(
                            'id' => 'radioparcial',                            
                            'name' => 'tipo_pago',                                                      
                            'onclick' => 'mostrarCuotas()',                            
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
                            'id' => 'radioefectivo',                            
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
                        'label' => 'Débito/Crédito',
                        'value' => 'debito/credito',
                        'attributes' => array(                            
                            'name' => 'forma_pago',                            
                            'onclick' => 'mostrarDebito()',                            
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
                'name' => 'id_banco',
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
        
        // - Text - ///////////////////////////////// Total a Pagar
        $this->add(array(
            'type' => 'text',
            'name' => 'montototal',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'montototal',
                'disabled'=>'disabled',                                              
                'required' => 'true'                
            )
        ));
        
        // - File - ///////////////////////////////// Imagen
        $this->add(array(            
            'name' => 'nombrefile',            
            'attributes' => array(
                'type' => 'file',
                'class' => 'form-control',
                'id' => 'fileupload',                                                              
                'required' => 'true',
                'onchange' =>'selecciona()',               
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
                'type' => 'reset',
                'value' => 'Cancelar',
                'onclick' => 'closeModal();',
                'title' => 'Cancelar',
                'class' => 'btn btn-danger'
            ),
        ));        
     
     }

}