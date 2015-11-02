<?php
namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class FondosTable extends TableGateway
{
    private $nombre;
    private $titular;
    private $rut;
    private $dv;
    private $id_banco;
    private $ultimo_cheque;
    private $numero;
    private $correo;
    private $saldo;
    private $detalle;    
    private $cuota_reserva;
    private $activo;    
    

    public $dbAdapter;

    

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_fondo', $adapter, $databaseSchema,$selectResultPrototype);
    }
      private function cargarCampos($datos=array())
    {    
        $this->nombre=$datos["nombre"];
        $this->titular=$datos["titular"];
        $this->rut=$datos["rut"];
        $this->dv=$datos["dv"];
        $this->id_banco=$datos["banco"];
        $this->ultimo_cheque=$datos["cheque"];
        $this->numero=$datos["numero"];
        $this->correo=$datos["correo"];        
        $this->saldo=$datos["saldo"];
        $this->detalle=$datos["detalle"];
        $this->cuota_reserva=$datos["cuota_reserva"];
        $this->activo=$datos["activo"];
           
    }
    public function getDatos()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();
        return $recorre;
    } 
    public function getCombo()
    {
        $datos = $this->select(array('activo'=>'1'));
        $recorre = $datos->toArray();      
        for($i=0;$i<count($recorre);$i++)
        {
          $resultado[$recorre[$i]['id']] = $recorre[$i]['nombre']; 
        }
        return $resultado;
    } 
    
    public function getFondoOper()
    {
        $datos = $this->select(array('nombre'=>'Fondo Operacional'));
        $recorre = $datos->toArray();
        return $recorre;
    } 
    public function getFondoRes()
    {
        $datos = $this->select(array('nombre'=>'Fondo de Reserva'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function getCajaChica()
    {
        $datos = $this->select(array('nombre'=>'Caja Chica'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    
    public function getFondoId($id)
    {
        $datos = $this->select(array('id'=>$id));
        $recorre = $datos->toArray();
        return $recorre;
    } 
    
    public function sumaFondo(Adapter $dbAdapter,$id_fondo,$monto)
    {         
         $this->dbAdapter=$dbAdapter;
         $query = "update sis_w_fondo set saldo = saldo+".$monto." where id=".$id_fondo;
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result;
    }
    
    public function restaFondo(Adapter $dbAdapter,$id_fondo,$monto)
    {         
         $this->dbAdapter=$dbAdapter;
         $query = "update sis_w_fondo set saldo = saldo-".$monto." where id=".$id_fondo;
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result;
    }
    
    public function guardarFondo($id, $data=array())
    {
                self::cargarCampos($data);
                $array=array
             (
                'nombre'=>$this->nombre,
                'titular'=>$this->titular,
                'rut'=>$this->rut,
                'dv'=>$this->dv,
                'id_banco'=>$this->id_banco,
                'ultimo_cheque'=>$this->ultimo_cheque,
                'numero'=>$this->numero,
                'correo'=>$this->correo,
                'saldo'=>$this->saldo,
                'detalle'=>$this->detalle,
                'cuota_reserva'=>$this->cuota_reserva                               
                
             );
        
                  $this->update($array, array('id' => $id));
    }
    
    public function nuevoFondo($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'nombre'=>$this->nombre,
                'titular'=>$this->titular,
                'rut'=>$this->rut,
                'dv'=>$this->dv,
                'id_banco'=>$this->id_banco,
                'ultimo_cheque'=>$this->ultimo_cheque,
                'numero'=>$this->numero,
                'correo'=>$this->correo,
                'saldo'=>$this->saldo,
                'detalle'=>$this->detalle,
                'cuota_reserva'=>$this->cuota_reserva,
                'activo'=>'1'                
                
             );
               $this->insert($array);
               $id = $this->lastInsertValue;
               return $id;
        }
    }

