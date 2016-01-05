<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class SeguroForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
     
        //Hidden inputs
            $this->add(array('type' => 'hidden','name' => 'origen'));
            $this->add(array('type' => 'hidden','name' => 'id_tipo_egreso'));
            $this->add(array('type' => 'hidden','name' => 'concepto', 'attributes' => array('value' => 'Seguros del condominio')));            
            $this->add(array('type' => 'hidden','name' => 'url_poliza', 'attributes' => array('id' => 'url_poliza')));
            $this->add(array('type' => 'hidden','name' => 'id_pk','attributes' => array('value' => '0')));
        
     //Input Cuenta type=file*******FILE*****poliza
        $this->add(array(
    'type' => 'Zend\Form\Element\File',
    'name' => 'filepoliza',
    'attributes' => array(
        'onchange' => 'selecciona()',
        'required' => 'true',
        'id' => 'filepoliza',
            )
        ));
        
    //Input //////////////////////////////Y/////// Aeguradora (Proveedores)
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_proveedor',
            'attributes' => array(
                'class' => 'form-control',
                'style' => 'max-width: 80%;',
                'required' => 'true',
                'id' => 'id_proveedor',
            )
        ));
           
        
      //Input Cuenta type=text************poliza 
        $this->add(array(
            'type' => 'text',     
            'name' => 'poliza',       
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'poliza',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
       //Input Cuenta type=text************riesgo
        $this->add(array(
            'type' => 'text',
            'name' => 'riesgo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'riesgo',                
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************prima
        $this->add(array(
            'type' => 'text',
            'name' => 'valor_prima',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'valor_prima',
                'onkeyup' => 'formatMonto()',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************cuotas
        $this->add(array(
            'type' => 'text',
            'name' => 'cuotas',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cuotas',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************vigencia
        $this->add(array(
            'type' => 'date',
            'name' => 'vigencia',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'vigencia',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));

        //Input Cuenta type=text************vigenciafin
        $this->add(array(
            'type' => 'date',
            'name' => 'vigenciafin',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'vigenciafin',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));   
        
        //Input Cuenta type=text*********detalle
        $this->add(array(
            'type' => 'textarea',
            'name' => 'detalle',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'detalle',
                'rows' => '3',                
                'style' => 'width: 50%;'
            )
        ));
                 
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendseg',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendseg',
                'value' => 'Guardar',
                'title' => 'Enviar',
                'class' => 'btn btn-info btn-circle btn-lg'
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