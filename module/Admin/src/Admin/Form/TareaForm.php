<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class TareaForm extends Form

{

     public function __construct($name = null)

     {
        parent::__construct($name);        

        // Hidden ////////////////////////////// id_pk
        $this->add(array(
            'name' => 'id_pk',
            'type'  => 'hidden',
            'attributes' => array(                
                'value' => '0',                
            ),        
        ));
                

        // Text ////////////////////////////// Nombre
        $this->add(array(
            'name' => 'nombre',
            'type'  => 'text',
            'attributes' => array(                
                'class' => 'form-control',
                'required' =>'true',
            ),        
        )); 
        
        // Checkbox //////////////////////////// Urgente
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'urgente',
            'options' => array(            
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
                )
            )); 

        
        // Select /////////////////////////////// Area Responsable
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'area_responsable',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'area_responsable',                
                'required' => 'true',
                'onchange' => 'comboResponsable()',
                'options' => array
                (
                    'conserje' => 'Conserje/Mayordomo',
                    'proveedor' => 'Proveedor',
                    'aseo' => 'Personal de aseo',
                    'administracion' => 'Administración',
                    'comite' => 'Comité',
                )                
            )
        ));
        
        // Select /////////////////////////////// Responsable
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'responsable',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'responsable',                
                'required' => 'true',          
            )
        ));
        
        // Select /////////////////////////////// Pago
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pago',
            'attributes' => array(
                'class' => 'form-control',                                                
                'options' => array
                (
                    'aplica' => 'Aplica',
                    'na' => 'No aplica',
                )                
            )
        ));
        
        // Select /////////////////////////////// Estado
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'estado',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'estado_tarea',                                
                'required' => 'true',
                'options' => array
                (
                    'pendiente' => 'Pendiente',
                    'realizada' => 'Realizada',
                )                
            )
        ));
        
        // Text ///////////////////////////////// Avance
        $this->add(array(
            'name' => 'avance',
            'type'  => 'text',            
            'attributes' => array(   
                'id' =>'avance_tarea',             
                'class' => 'form-control',
                'required' =>'true',
                'placeholder'  => 'Solo números',
            ),        
        ));
        
        // Text ////////////////////////////// Fecha inicio
        $this->add(array(
            'name' => 'fecha',
            'type'  => 'date',
            'attributes' => array(                
                'class' => 'form-control',
                'required' =>'true',
            ),        
        ));
        
        
        //Boton Enviar

        $this->add(array(
            'name' => 'sendtarea',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Ingresar nueva tarea',
                'id' => 'test2',
                'title' => 'Enviar',
                'class' => 'btn btn-success'
            ),
        ));
        
        //Boton Enviar

        $this->add(array(
            'name' => 'eliminar',
            'attributes' => array(                
                'value' => 'Ingresar nueva tarea',
                'id' => 'eliminaTarea()',
                'title' => 'Eliminar Tarea',
                'class' => 'btn btn-danger'
            ),
        ));

        //Boton Cancelar

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Atras',
                'title' => 'Cancelar',
                'class' => 'btn btn-info',
                'data-dismiss' => 'modal'
            ),
        ));        

     

     }



}