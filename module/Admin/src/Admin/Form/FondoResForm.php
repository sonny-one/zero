<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class FondoResForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
        // - Hidden - //////////////////////////// Nombre
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'nombre',
            'attributes' => array(
                'id' => 'nombre',
                'value' => 'Fondo de Reserva'
            )
        ));
        
        // - Hidden - //////////////////////////// PK
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk',
            'attributes' => array(
                'id' => 'id_pk_fres',
                'value' => '0'
            )
        ));
        
        // - Hidden - //////////////////////////// id_BANCO
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_banco',
            'attributes' => array(
                'id' => 'idbancores',                
            )
        ));
        
        //Input Cuenta type=text************numero
        $this->add(array(
            'type' => 'text',            
            'attributes' => array(
                'name' => 'numero',
                'onkeypress'=>'return isNumber(event);',
                'class' => 'form-control',
                'id' => 'numerores',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
       //Input Cuenta type=text************rut
        $this->add(array(
            'type' => 'text',
            'name' => 'rut',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'rutres',                
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Banco//////////////////////// Banco 
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'name' => 'banco',
                'id' => 'bancores',
                'class' => 'form-control',
                'required' => 'true',
                'style' => 'max-width: 80%;'                
            )
        ));   
                                                
        
        //Input Cuenta type=text************titular
        $this->add(array(
            'type' => 'text',
            'name' => 'titular',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'titularres',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************saldo
        $this->add(array(
            'type' => 'text',
            'name' => 'saldo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'saldores',
                'onblur' =>   'formatMontores()',
                'onkeypress'=>'return isNumber(event);',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        

        //Input Cuenta type=text************mail
        $this->add(array(
            'type' => 'email',
            'name' => 'correo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'emailres',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        )); 
        //Input Cuenta type=text************cuota
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'cuota_reserva',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cuotares',
                'required' => 'true',
                'style' => 'max-width: 80%;',
                'options' => array(
                    '0'=>'1',
                    '1'=>'2',
                    '2'=>'3',
                    '3'=>'4',
                    '4'=>'5',
                    '5'=>'6',
                    '6'=>'7',
                    '7'=>'8',
                    '8'=>'9',
                    '9'=>'10',
                )
            )
        ));    
        
        //Input Cuenta type=text************detalles
        $this->add(array(
            'type' => 'textarea',
            'name' => 'detalle',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'detallefores',
                'rows' => '3',                
                'style' => 'width: max;'
            )
        ));       
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendfin',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendres',
                'value' => 'Guardar',
                'title' => 'Enviar',
                'class' => 'btn btn-success'
            ),
        ));
        //Boton Cancela
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