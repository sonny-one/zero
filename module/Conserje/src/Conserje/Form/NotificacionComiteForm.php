<?php

namespace Conserje\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class NotificacionComiteForm extends Form
{
     public function __construct($name = null)
     {
        parent::__construct($name);
         $this->add(array(  
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_pk_auto',
            'attributes' => array(
                'id' => 'id_pk_auto',
                'value' => '0'
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_persona_v',
            'attributes' => array(
                'id' => 'id_persona_v',
                'value' => '0'
            )
        ));
         $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id_persona_t',
            'attributes' => array(
                'id' => 'id_persona_t',
                'value' => '0'
            )
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_unidad',
            'attributes' => array(
                'id' => 'id_unidad',
                'class' => 'form-control'
            )

        ));

        $this->add(array(
            'name' => 'rutV',
            'attributes' => array(
                'id' => 'rutV',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder'=>'Ingrese Rut'
                
            ),

        ));

        $this->add(array(
            'name' => 'dniV',
            'attributes' => array(
                'id' => 'dniV',
                'type' => 'text',
                'class' => 'form-control'
                
            ),

        ));        


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_motivo',
            'attributes' => array(
                'id' => 'id_motivo',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'nombreV',
            'attributes' => array(
                'id' => 'nombreV',
                'type' => 'text',
                'class' => 'form-control',
                'readonly'=>'true'
                
            ),

        ));
        $this->add(array(
            'name' => 'apellidoV',
            'attributes' => array(
                'id' => 'apellidoV',
                'type' => 'text',
                'class' => 'form-control',
                'readonly'=>'true'
                
            ),

        ));
        $this->add(array(
            'name' => 'contactoV',
            'attributes' => array(
                'id' => 'contactoV',
                'type' => 'text',
                'class' => 'form-control',
                'readonly'=>'true'
                
            ),

        ));
        $this->add(array(
            'name' => 'fechaHoraV',
            'attributes' => array(
                'id' => 'fechaHoraV',
                'type' => 'text',
                'class' => 'form-control'
                
            ),

        )); 
        
        
         $this->add(array(
            'name' => 'btnRegistrar',
            'attributes' => array(
                'id' => 'btnRegistrar',
                'type' => 'button',
                'value' => 'Registrar Visita',
                'title' => 'Registrar',
                'class' => 'btn btn-success',
                
                
            ),
        ));
        $this->add(array(
            'name' => 'btnVincular',
            'attributes' => array(
                'id' => 'btnVincular',
                'type' => 'button',
                'value' => 'Vincular Estacionamiento',
                'class' => 'btn btn-success',
                'data-toggle'=>'modal',
                 'data-target'=>"#modalMapa"
            ),
        )); 
        
        $this->add(array(
            'name' => 'nombreEst',
            'attributes' => array(
                'id' => 'nombreEst',
                'type' => 'text',
                'class' => 'form-control',
                'readonly'=>'true'
                
            ),

        ));
        $this->add(array(
            'name' => 'modeloAuto',
            'attributes' => array(
                'id' => 'modeloAuto',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder'=>'Ingrese el modelo del auto'
                
            ),

        ));  
        $this->add(array(
            'name' => 'patenteAuto',
            'attributes' => array(
                'id' => 'patenteAuto',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder'=>'Ingrese la placa del auto'
                
            ),

        ));               
                               
        $this->add(array(
            'type' => 'textarea',
            'name' => 'observacionAuto',
            'attributes' => array(
                'id' => 'observacionAuto',
                'class' => 'form-control',
                'rows' => '2',
                'placeholder'=>'Ingrese alguna observacion',
                'maxlength'=>'200'
            ),
        ));

         $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'aplicaMulta',
            'attributes' => array(
                'id' => 'aplicaMulta',
                'class' => 'form-control',
                'options'=>array("1"=>"Si","0"=>"No")
            )
        ));

        /*$this->add(array(
            'name' => 'descripcionfile',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder'=>'Ingrese descripcion del archivo',
            ),

        ));
        $this->add(array(
            'name' => 'nombrefile',
            'attributes' => array(
                'type'  => 'file',
                'id'=>'fileupload',
                'class' => 'form-control',
                'onchange' =>'selecciona()',
            ),
        ));                 

        

        //Boton Enviar
        $this->add(array(
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
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
        ));    */    

     }

}