<?php

namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class PagoTrabajadorForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);

         //Input ///// /////////////////////////// Concepto de Egreso (input)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'concepto',                        
            'attributes' => array(                                                   
                'required' => 'true',                                        
            )
        ));
        
        //Input ///// /////////////////////////// Cuotas (input)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'cuotas',     
            'attributes' => array(                                                   
                'required' => 'true',                                            
            )
        ));

        //Input ///// /////////////////////////// Tipo_egreso (TEXT)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'id_tipo_egreso',            
            'attributes' => array(                                                   
                'required' => 'true',                             
            )
        ));
        
        //Input ///// /////////////////////////// Foto (input)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'foto',            
            'attributes' => array(                                                   
                'required' => 'true',
                'id' => 'foto_tr',                             
            )
        ));
        
        //Input ///// /////////////////////////// id_trabajador (TEXT)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'id_trabajador',            
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
        
        //Input ///// /////////////////////////// Foto (input)
        $this->add(array(
            'type' => 'hidden',
            'name' => 'foto',            
            'attributes' => array(                                                   
                'required' => 'true',
                'id' => 'foto_tr',                             
            )
        ));
        
        //Input //////////////////////////////// FONDO ORIGEN  
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_fondo',            
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'id_fondo_origen_ptrabajador',                
                'required' => 'true',                
            )
        ));
        
        //Input ///////////////////////////////// Trabajador
        $this->add(array(
            'type' => 'text',
            'name' => 'trabajador',             
            'attributes' => array(                
                'id' => 'nombre_trabajador',
                'disabled' => 'disabled',
                'class' => 'form-control',                                                 
                'required' => 'true'                               
            )
        ));

       // - Text - ///////////////////////////////// Leyes Sociales
        $this->add(array(
            'type' => 'text',
            'name' => 'leysocial',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'leysocial_tr',                              
                'onkeyup' => 'formatMontoTrab("leysocial_tr")',                
                'onkeypress'=>'return esNumber(event);', 
                'required' => 'true'                
            )
        ));
        
        // - Text - ///////////////////////////////// Sueldo
        $this->add(array(
            'type' => 'text',
            'name' => 'sueldo',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'sueldo_tr',                                              
                'onkeyup' => 'formatMontoTrab("sueldo_tr")',
                'onkeypress'=>'return esNumber(event);', 
                'required' => 'true'                
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
                            'id' => 'radioefectivo_tr',                            
                            'onclick' => 'mostrarEfectivoTr()',                            
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
                            'onclick' => 'mostrarTransTr()',                            
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
                            'onclick' => 'mostrarChequeTr()',                            
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
                            'onclick' => 'mostrarDebitoTr()',                            
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
                'id' => 'fecha_pago_tr',
                'class' => 'form-control',
                'required' => 'true',                           
            )
        )); 
        
        // - Select - //////////////////////////// Banco 
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'name' => 'id_banco',
                'id' => 'banco_pago_trab',
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
                'id' => 'nmrooperacion_tr',                                
                'required' => 'true'                
            )
        ));
        
        // - Text - ///////////////////////////////// N° Cheque 
        $this->add(array(
            'type' => 'text',
            'name' => 'nmrocheque',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nmrocheque_tr',                              
                'required' => 'true'                
            )
        ));    
        
        // - Text - ///////////////////////////////// Total a Pagar
        $this->add(array(
            'type' => 'text',
            'name' => 'montototal',            
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'montototal_tr',
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
                'id' => 'egreso_file_tr',                                                              
                'required' => 'true',
                'onchange' =>'seleccionaTr()',               
            )
        )); 
        
        // - TextArea - ///////////////////////////////// Observacion
        $this->add(array(
            'type' => 'textarea',
            'name' => 'observacion',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'observacion_egreso_tr',
                'maxlength'=>'40',
                'onKeyDown' => 'cuentaTr()',
                'onKeyUp' => 'cuentaTr()',
                'rows' => '3',                
                'style' => 'width: max;'                
            )
        ));  
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendpago',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendpago_tr',
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
                'data-dismiss' => 'modal',
                'title' => 'Cancelar',
                'class' => 'btn btn-danger'
            ),
        ));       
     
     }

}