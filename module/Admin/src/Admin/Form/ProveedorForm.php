<?php
namespace Admin\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;


class ProveedorForm extends Form
{
     
     public function __construct($name = null)
     {
        parent::__construct($name);
          
        
        // Text //////////////////////////////// Nombre 
        $this->add(array(
            'type' => 'text',
            'name' => 'nombre',            
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'nombre',
                'required' => 'true'
            )
        ));
        
        // Text ////////////////////////////////  RUT
        $this->add(array(
            'type' => 'text',
            'name' => 'rut',            
            'attributes' => array(                
                'class' => 'form-control',
                'id' => 'rut_prov',
                'required' => 'true',
                'data-toggle'=> 'popover',                           
                'data-placement'=>'right'                
                
                
            )
        ));
        
        //text ////////////////////////////////  telefono
        $this->add(array(
            'type' => 'text',
            'name' => 'telefono',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'telefono',                                              
            )
        ));
                
        //text  ///////////////////////////////// direccion
        $this->add(array(
            'type' => 'text',
            'name' => 'direccion',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'direccion',                                     
            )
        ));
        
        // mail  ///////////////////////////////// Correo
        $this->add(array(
            'type' => 'email',
            'name' => 'correo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'correo',                                                
            )
        ));
        
        //text  ///////////////////////////////// Ciudad
        $this->add(array(
            'type' => 'text',
            'name' => 'ciudad',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'ciudad',                
                'required' => 'true'                
            )
        ));  
        
        //Select ///////////////////////////////// Categoria
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'categoria',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'categoria',                
                'required' => 'true',
                'onchange' => 'comboServicio()'               
            )
        ));

        //Select ///////////////////////////////// Servicio
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'servicio',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'servicio',                
                'required' => 'true',               
            )
        ));    
        
        //Select ///////////////////////////////// Fijo
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'fijo',
            'options' => array(            
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
        )
        ));
    
            // - Select - //////////////////////////// Banco 
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'name' => 'id_banco',
                'id' => 'banco',
                'class' => 'form-control',                              
            )
        )); 
    
        //text  ///////////////////////////////// Nª Cliente
        $this->add(array(
            'type' => 'text',
            'name' => 'nmro_cliente',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nmro_cliente'                
            )
        ));
        
        //text  ///////////////////////////////// Obeservacion
        $this->add(array(
            'type' => 'textarea',
            'name' => 'observacion',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder'=>'Escriba aqui',
                'id' => 'observacion',
                'rows' => '4',                
                'style' => 'width: max;'
            )
        ));
        
        //Boton Enviar
        $this->add(array(
            'name' => 'sendprov',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'send_prov',
                'value' => 'Ingresar Nuevo Proveedor',
                'title' => 'Enviar',
                'class' => 'btn btn-success'
            ),
        ));
        //Boton Cancelar
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Cancelar',
                'data-dismiss' => 'modal',
                'title' => 'Cancelar',
                'class' => 'btn btn-danger'
            ),
        ));
        
         // Nuevo servicio //
        //Select ///////////////////////////////// Combo Proveedores
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'proveedores',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'proveedores',                
                'required' => 'true'                               
            )
        ));                
     
     }

}