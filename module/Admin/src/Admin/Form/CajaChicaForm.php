<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class CajachicaForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
        //Input type=hidden pk table
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk',
            'attributes' => array(
                'id' => 'id_pk_caja',
                'value' => '0'
            )
        ));

        //Input Cuenta type=text************saldo
        $this->add(array(
            'type' => 'text',
            'name' => 'saldo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'saldocaja',
                'onkeyup'=> 'format(this)',
                'onchange' => 'format(this)',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************importe
        $this->add(array(
            'type' => 'text',
            'name' => 'importe',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'importecaja',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        //Input Cuenta type=text************frecuencia
        $this->add(array(
            'type' => 'text',
            'name' => 'frecuencia',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'frecuenciacaja',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));           
        
    //Input Cuenta type=text************detalles
        $this->add(array(
            'type' => 'textarea',
            'name' => 'detalles',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'detallescaja',
                'rows' => '3',                
                'style' => 'width: max;'
            )
        ));     

        //Boton Enviar
        $this->add(array(
            'name' => 'sendcaja',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendcaja',
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