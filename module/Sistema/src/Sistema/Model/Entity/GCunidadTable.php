<?php

namespace Sistema\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class GCunidadTable extends TableGateway

{

    private $id_unidad;
    private $mes;
    private $year;
    private $monto;
    private $pagado;    
    public $dbAdapter;

    
    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('sis_w_gastocomun_u', $adapter, $databaseSchema,$selectResultPrototype);
    }
      private function cargarCampos($datos=array())
    {    
        $this->id_unidad=$datos["id_unidad"];
        $this->mes=$datos["mes"];
        $this->year=$datos["year"];
        $this->monto=$datos["monto"];
        $this->pagado=$datos["pagado"];
    }
    public function getPagados()
    {
        $datos = $this->select(array('pagado'=>'s'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function getNoPagados()
    {
        $datos = $this->select(array('pagado'=>'n'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function getPagado($id_unidad)
    {
        $datos = $this->select(array('id_unidad'=>$id_unidad,'pagado'=>'s'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function getNoPagado($id_unidad)
    {
        $datos = $this->select(array('id_unidad'=>$id_unidad,'pagado'=>'n'));
        $recorre = $datos->toArray();
        return $recorre;
    }
    public function pagoTotalGasto(Adapter $dbAdapter,$id_unidad){
         $this->dbAdapter=$dbAdapter;
         $query = "update sis_w_gastocomun_u set pagado ='s' where id_unidad =".$id_unidad;
         $result=$this->dbAdapter->query($query,Adapter::QUERY_MODE_EXECUTE);
         return $result;
    }
        public function pagoParcialGasto($id)
    {    
        $array=array('pagado'=>'s');
        
        $this->update($array, array('id' => $id));
    }                    
    public function nuevoGasto($data=array())
    {
             self::cargarCampos($data);
             $array=array
             (
                'nombre'=>$this->id_unidad,
                'titular'=>$this->mes,
                'rut'=>$this->year,
                'banco'=>$this->monto,
                'numero'=>$this->pagado,
                'pagado'=>'n'                                
             );
               $this->insert($array);
        }            
}

