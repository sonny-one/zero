<?php

namespace Admin\Form;



use Zend\Captcha\AdapterInterface as CaptchaAdapter;

use Zend\Form\Element;

use Zend\Form\Form;

use Zend\Captcha;

use Zend\Form\Factory;





class MultasForm extends Form

{

     

     public function __construct($name = null)

     {

        parent::__construct($name);

        

        //Input type=hidden pk table

         $this->add(array(

            'type' => 'Zend\Form\Element\Hidden',

            'name' => 'id_pk',

            'attributes' => array(

                'id' => 'id_pk_multa',

                'value' => '0'

            )

        ));

    //***************************** Select % - UF - CLP     

     $this->add(array(

             'type' => 'Zend\Form\Element\Select',

             'name' => 'tipo_cobro',             

             'attributes' => array(

                'class' => 'form-control',  

                'id' => 'select1',                                            

                ),

             'options' => array(

                     'label' => 'Cobro de Interés en:',

                     'value_options' => array(

                             '0' => '',

                             '1' => '%    del gasto comun',

                             '2' => 'UF   Unidad de Fomento',

                             '3' => '$    Peso Chileno (CLP)',                             

                     ),

             )

     ));

        

        //Input Cuenta type=text************valor

        $this->add(array(

            'type' => 'text',

            'name' => 'valor',

            'attributes' => array(

                'class' => 'form-control',

                'id' => 'valorint',

                'onkeyup'=> 'format(this)',

                'onchange' => 'format(this)',

                'required' => 'true',

                'style' => 'max-width: 80%;'

            )

        ));

                

        //Input Cuenta type=text************ruidos 

        $this->add(array(

            'type' => 'text',

            'name' => 'ruidos',

            'attributes' => array(

                'class' => 'form-control',

                'id' => 'ruidos',

                'required' => 'true',

                'style' => 'max-width: 80%;'

            )

        ));

                

        //Input Cuenta type=text************mascota

        $this->add(array(

            'type' => 'text',

            'name' => 'mascota',

            'attributes' => array(

                'class' => 'form-control',

                'id' => 'mascota',

                'required' => 'true',

                'style' => 'max-width: 80%;'

            )

        ));           

        

    //Input Cuenta type=text************Est. Visita

        $this->add(array(

            'type' => 'text',

            'name' => 'visita',

            'attributes' => array(

                'class' => 'form-control',

                'placeholder'=>'Escriba aqui',

                'id' => 'visitamulta',                     

                'style' => 'width: max;'

            )

        ));     



        //Boton Enviar

        $this->add(array(

            'name' => 'sendmulta',

            'attributes' => array(

                'type' => 'submit',

                'id' => 'sendmulta',

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