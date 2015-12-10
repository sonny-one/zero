<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class LavanderiaForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
        //Input type=hidden pk table
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk',
            'attributes' => array(
                'id' => 'id_pk_lav',
                'value' => '0'
            )
        ));
        
        $this->add(array(
        'type' => 'Zend\Form\Element\Radio',
        'name' => 'estadolav1',
        'options' => array(            
            'value_options' => array(
                array(
                'value' => '0',                
                'label' => 'Si',
                'attributes' => array(
                       'id' => 'lavsi',
                       'name' => 'estado',
                       ),
                ),                
            ),
        ),
    ));
    
    $this->add(array(
        'type' => 'Zend\Form\Element\Radio',
        'name' => 'estadolav2',        
        'options' => array(            
            'value_options' => array(
                    array(
                'value' => '1',                
                'label' => 'No',
                'attributes' => array(
                       'id' => 'lavno',
                       'name' => 'estado',
                       ),
                ),
            ),
        ),
    ));
        
        //Input Cuenta type=text************lavadoras
        $this->add(array(
            'type' => 'text',            
            'attributes' => array(
                'name' => 'lavadoras',
                'class' => 'form-control',
                'id' => 'lavadoras',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
       //Input Cuenta type=text************secadoras
        $this->add(array(
            'type' => 'text',
            'name' => 'secadoras',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'secadoras',                
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
        //Input Cuenta type=text************valor
        $this->add(array(
            'type' => 'text',
            'name' => 'valor',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'valorlav',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
                
        
        //Input Cuenta type=text************horario
        $this->add(array(
            'type' => 'text',
            'name' => 'horario',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'horario',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));

        //Input Cuenta type=text************horariofin
        $this->add(array(
            'type' => 'text',
            'name' => 'horariofin',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'horariofin',
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
            'name' => 'sendlav',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendlav',
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