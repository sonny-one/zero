<?php

namespace Sistema\Model\Entity\General;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;

class PersonaTable extends TableGateway

{ 
    private $rut;
    private $dv;
    private $dni;
    private $tipo;
    private $nombre;
    private $apellido;
    private $apellido_2;
    private $telefono;
    private $telefono_2;
    private $direccion;
    private $ciudad;
    private $pais;
    private $correo;
    private $correo_2;
    private $foto;
    private $observacion;
    private $user_create;


    public $dbAdapter;

    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_m_persona', $adapter, $databaseSchema,$selectResultPrototype);
    }



        private function cargarCampos($datos=array())
    {    
		$this->rut=isset($datos["rut"])?$datos["rut"]:"";
        $this->dv=isset($datos["dv"])?$datos["dv"]:"";
        $this->dni=isset($datos["dni"])?$datos["dni"]:"";
        $this->tipo=isset($datos["tipo"])?$datos["tipo"]:"natural";   
        $this->nombre=isset($datos["nombre"])?$datos["nombre"]:"";
        $this->apellido=isset($datos["apellido"])?$datos["apellido"]:"";
        $this->apellido_2=isset($datos["apellido2"])?$datos["apellido2"]:"";
        $this->telefono=isset($datos["telefono"])?$datos["telefono"]:"";
        $this->telefono_2=isset($datos["telefono_2"])?$datos["telefono_2"]:"";
        $this->direccion=isset($datos["direccion"])?$datos["direccion"]:"";
        $this->ciudad=isset($datos["ciudad"])?$datos["ciudad"]:"";
        $this->pais=isset($datos["pais"])?$datos["pais"]:"";        
        $this->correo=isset($datos["correo"])?$datos["correo"]:"";
        $this->correo_2=isset($datos["correo_2"])?$datos["correo_2"]:"";
        $this->observacion=isset($datos["observacion"])?$datos["observacion"]:"";
        $this->user_create=isset($datos["user_create"])?$datos["user_create"]:"";                   
    }

        public function nuevaPersona($data=array())

    {
            self::cargarCampos($data);
             $array=array
             (
                'rut'=>$this->rut,
                'dv'=>$this->dv,
                'dni'=>$this->dni,
                'tipo'=>$this->tipo,
                'nombre'=>$this->nombre,
                'apellido'=>$this->apellido,
                'apellido_2'=>$this->apellido_2,
                'telefono'=>$this->telefono,
                'telefono_2'=>$this->telefono_2,
                'direccion'=>$this->direccion,
                'ciudad'=>$this->ciudad,
                'pais'=>$this->pais,                
                'correo'=>$this->correo,
                'correo_2'=>$this->correo_2,
                'observacion'=>$this->observacion,                                
                'user_create'=>$this->user_create
             );

               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
               
        }
    
    public function editarPersona($id,$data=array())

    {
            self::cargarCampos($data);
             $array=array
             (
                'rut'=>$this->rut,
                'dv'=>$this->dv,
                'dni'=>$this->dni,
                'tipo'=>$this->tipo,
                'nombre'=>$this->nombre,
                'apellido'=>$this->apellido,
                'apellido_2'=>$this->apellido_2,
                'telefono'=>$this->telefono,
                'telefono_2'=>$this->telefono_2,  
                'direccion'=>$this->direccion,
                'ciudad'=>$this->ciudad,
                'pais'=>$this->pais,              
                'correo'=>$this->correo,
                'correo_2'=>$this->correo_2,
                'observacion'=>$this->observacion,                                
                'user_create'=>$this->user_create
             );

               $this->update($array,array('id'=>$id));
               
        }
    
    public function getDatosId($id)

    {
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
        return $recorre;
    } 

    public function getDatosMail($mail)

    {
        $datos = $this->select(array('correo'=>$mail));
        $recorre = $datos->toArray();
        return $recorre;
    } 

    public function getDatosRut($rut)

    {

        //$datos = $this->select(array('rut'=>$rut));
        $datos = $this->select(function (Select $select) use ($rut) {
        $where = new Where();
        $where->like('rut', $rut."%"); 
        $select->where($where);
    });
        
        $recorre = $datos->toArray();
        return $recorre;

    }
    
        public function getDatosOtro($otro)

    {

        //$datos = $this->select(array('rut'=>$rut));
        $datos = $this->select(function (Select $select) use ($otro) {
        $where = new Where();
        $where->like('dni', $otro."%"); 
        $select->where($where);
    });
        
        $recorre = $datos->toArray();
        return $recorre;

    }

}