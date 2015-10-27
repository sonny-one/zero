<?php

namespace Conserje\Form;



use Zend\Captcha\AdapterInterface as CaptchaAdapter;

use Zend\Form\Element;

use Zend\Form\Form;

use Zend\Captcha;

use Zend\Form\Factory;





class EncomiendaForm extends Form

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

        

        //Select Destinatario

        $this->add(array(

            'type' => 'Zend\Form\Element\Select',

            'name' => 'id_dpto',

            'attributes' => array(

                'class' => 'form-control',
                'id' => 'id_dpto'

            )

        ));

        

        //Input type=text Remitente

        $this->add(array(

            'name' => 'remitente',

            'attributes' => array(

                'type' => 'text',

                'class' => 'form-control',

                'placeholder' => 'Ingresar quien entrega',        

            ),

        ));



        //Select Detalles Entrega

       $this->add(array(

            'type' => 'textarea',

            'name' => 'descripcion',                    

            'attributes' => array(

                'rows' => '3',

                 'class' => 'form-control',   

                 'placeholder' => 'Escriba aqui...'                         

            ),

        ));

        

        //Input type=text Almacen

        $this->add(array(

            'name' => 'almacen',

            'attributes' => array(

                'type' => 'text',

                'class' => 'form-control',

                'placeholder' => 'Donde se guardó?',        

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

                'value' => 'Borrar',

                'title' => 'Cancelar',

                'class' => 'btn btn-danger'

            ),

        ));        

     

     }



}