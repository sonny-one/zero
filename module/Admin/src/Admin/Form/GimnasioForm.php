<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class GimnasioForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
        
        //Input type=hidden pk table
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk',
            'attributes' => array(
                'id' => 'id_pk_gim',
                'value' => '0'
            )
        ));
        
        $this->add(array(
        'type' => 'Zend\Form\Element\Radio',
        'name' => 'musica',
        'options' => array(            
            'value_options' => array(
                array(
                'value' => '0',                
                'label' => 'Si',
                'attributes' => array(
                       'id' => 'musicasi',
                       'name' => 'musica',
                       ),
                ),                
            ),
        ),
    ));
    
    $this->add(array(
        'type' => 'Zend\Form\Element\Radio',
        'name' => 'musica2',        
        'options' => array(            
            'value_options' => array(
                    array(
                'value' => '1',                
                'label' => 'No',
                'attributes' => array(
                       'id' => 'musicano',
                       'name' => 'musica',
                       ),
                ),
            ),
        ),
    ));
    
    $this->add(array(
        'type' => 'Zend\Form\Element\Radio',
        'name' => 'estadogim',
        'options' => array(            
            'value_options' => array(
                array(
                'value' => '0',                
                'label' => 'Si',
                'attributes' => array(
                       'id' => 'gimsi',
                       'name' => 'estado',
                       ),
                ),                
            ),
        ),
    ));
    
    $this->add(array(
        'type' => 'Zend\Form\Element\Radio',
        'name' => 'estadogim2',        
        'options' => array(            
            'value_options' => array(
                    array(
                'value' => '1',                
                'label' => 'No',
                'attributes' => array(
                       'id' => 'gimno',
                       'name' => 'estado',
                       ),
                ),
            ),
        ),
    ));
        
        //Input Cuenta type=text************trotadoras
        $this->add(array(
            'type' => 'text',            
            'attributes' => array(
                'name' => 'trotadoras',
                'class' => 'form-control',
                'id' => 'trotadoras',
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
       //Input Cuenta type=text************bicicletas
        $this->add(array(
            'type' => 'text',
            'name' => 'bicicletas',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'bicicletas',                
                'required' => 'true',
                'style' => 'max-width: 80%;'
            )
        ));
        
         //Input Cuenta type=text************pesas
        $this->add(array(
            'type' => 'text',            
            'attributes' => array(
                'name' => 'pesas',
                'class' => 'form-control',
                'id' => 'pesas',
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
                'id' => 'valorgim',
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
                'id' => 'horariogim',
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
                'id' => 'horariogimfin',
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
                'id' => 'reglasgim',
                'rows' => '4',                
                'style' => 'width: max;'
            )
        ));
                 
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendgim',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'sendgim',
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