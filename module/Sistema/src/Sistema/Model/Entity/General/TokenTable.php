<?php

namespace Sistema\Model\Entity\General;



use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Adapter\Adapter;

use Zend\Db\Sql\Sql;

use Zend\Db\ResultSet\ResultSet;



class TokenTable extends TableGateway

{

    private $id;

    private $token;

    private $mail;

    private $activo;



    public $dbAdapter;

    

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)

    {

        return parent::__construct('sis_w_token', $adapter, $databaseSchema,$selectResultPrototype);

    }

     

    private function cargarCampos($datos=array())

    {    
        $this->token=$datos["token"];
        $this->mail=$datos["mail"];          
    }

                    

    public function getDatos()

    {                

        $datos = $this->select(array('activo'=>'1',));

        $recorre = $datos->toArray();

        return $recorre;

    } 

    

    public function getDatosToken($token)

    {                

        $datos = $this->select(array('activo'=>'1','token'=>$token));

        $recorre = $datos->toArray();

        return $recorre;
    }
    
    public function nuevoToken($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'token'=>$this->token,
                'mail'=>$this->mail,
                'activo'=>'1',
             );
               $this->insert($array);
               
        }    

    public function borrarToken($id)
    {
        $array=array('activo'=>'0');
        $this->update($array, array('id' => $id));
    }

}

