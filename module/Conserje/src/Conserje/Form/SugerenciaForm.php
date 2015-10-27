<?php

namespace Conserje\Form;



use Zend\Captcha\AdapterInterface as CaptchaAdapter;

use Zend\Form\Element;

use Zend\Form\Form;

use Zend\Captcha;

use Zend\Form\Factory;





class SugerenciaForm extends Form

{

     

     public function __construct($name = null)

     {

        parent::__construct($name);

        

        //Input type=hidden pk table

         $this->add(array(

            'type' => 'Zend\Form\Element\Hidden',

            'name' => 'id_pk',

            'attributes' => array(

                'value' => '0'

            )

        ));

        

        //Select Remitente

        $this->add(array(

            'type' => 'Zend\Form\Element\Select',

            'name' => 'id_dpto',
            

            'attributes' => array(
                'id'=>'id_dpto',
                'class' => 'form-control'

            )

        ));

        

        //Input type=text receptor

        $this->add(array(

            'name' => 'receptor',

            'attributes' => array(

                'type' => 'text',

                'class' => 'form-control',

                'value' => 'Administrador',

                'readonly' => 'true'

            ),

        ));



        //Select Asunto

        $this->add(array(

            'type' => 'Zend\Form\Element\Select',

            'name' => 'id_tipo_asunto',

            'attributes' => array(

                'class' => 'form-control'

            )

        ));

        

        //Input type=textArea descripcion

        $this->add(array(

            'type' => 'textarea',

            'name' => 'descripcion',

            'attributes' => array(

                'class' => 'form-control',

                'rows' => '7',

                'placeholder'=>'Ingrese su sugerencia aqui',

                

                'maxlength'=>'450'

            ),

        ));

        

        $this->add(array(

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

        ));        

     

     }



}