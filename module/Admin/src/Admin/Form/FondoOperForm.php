<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class FondoOperForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
         //Input type=hidden pk table
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'nombre',
            'attributes' => array(
                'value' => 'Fondo Operacional'
            )
        ));
         //Input type=hidden/////////////////////id Banco
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'idbanco',
            'attributes' => array(
            'id' => 'idbanco'                
            )
        ));
        
        //Input type=hidden ////////////////////pk table
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk',
            'attributes' => array(
                'value' => '0'
            )
        ));
        
        //Input type=text///////////////////// Titular 
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'titular',
                'id' => 'titular',
                'class' => 'form-control',
                'required' => 'true',
                'style' => 'max-width: 80%;'             
            )
        ));
        
        //Input /////////////////////////////  RUT
        $this->add(array(
            'type' => 'text',            
            'attributes' => array(                
                'id' => 'rut',
                'name' => 'rut',
                'class' => 'form-control',
                 'required' => 'true',
                 'style' => 'max-width: 80%;'
            )
        ));

        //Input Cuenta /////////////////////////// Numero 
        $this->add(array(
            'type' => 'text',
            'name' => 'numero',
            'attributes' => array(
                'class' => 'form-control',
                'onkeypress'=>'return isNumber(event);',
                'id' => 'numero',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Banco//////////////////////// Banco 
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'name' => 'banco',
                'id' => 'bancooper',
                'class' => 'form-control',
                'required' => 'true',
                'style' => 'max-width: 80%;'                
            )
        ));       
        
         //Input Banco//////////////////////// correo 
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'correo',
                'id' => 'emailfinanciera',
                'class' => 'form-control',
                'required' => 'true',
                'style' => 'max-width: 80%;'                
            )
        ));   
        //Input Banco//////////////////////// saldo 
        $this->add(array(
            'type' => 'text',
            'name' => 'saldo',
            'attributes' => array(                
                'id' => 'saldooper',
                'class' => 'form-control',
                'onblur' => 'formatMonto()',
                'onkeypress'=>'return isNumber(event);',
                'required' => 'true',
                'style' => 'max-width: 80%;'                
            )
        )); 
        
        //Input Banco//////////////////////// Ultimo Cheque 
        $this->add(array(
            'type' => 'text',
            'attributes' => array(
                'name' => 'cheque',
                'id' => 'ultimocheque',
                'onkeypress'=>'return isNumber(event);',
                'class' => 'form-control',                
                'style' => 'max-width: 80%;'                
            )
        ));
        
        //Input Cuenta type=text************detalles
        $this->add(array(
            'type' => 'textarea',
            'name' => 'detalle',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'detallefoper',
                'rows' => '4',                
                'style' => 'width: max;'
            )
        ));  
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendfin',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'guardarfinanciera',
                'value' => 'Guardar',
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