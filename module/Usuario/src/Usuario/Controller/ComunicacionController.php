<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

use Sistema\Util\SysFnc;

use Sistema\Model\Entity\ReclamoTable;
use Sistema\Model\Entity\TipoAsuntoTable;
use Sistema\Model\Entity\CtacteTable;
use Sistema\Model\Entity\LavanderiaTable;
use Sistema\Model\Entity\InfocomgralTable;
use Sistema\Model\Entity\EdificacionTable;
use Sistema\Model\Entity\AscensorTable;
use Sistema\Model\Entity\FondosTable;
use Sistema\Model\Entity\PartidaMantTable;
use Sistema\Model\Entity\Prueba2Table;
use Sistema\Model\Entity\NotaMantTable;
use Sistema\Model\Entity\TareaTable;
use Sistema\Model\Entity\TrabajadorTable;
use Sistema\Model\Entity\ProveedorTable;
use Sistema\Model\Entity\InventarioTable;


class ComunicacionController extends AbstractActionController
{
    
    public function indexAction()
    
    {                                       
        $this->layout('layout/usuario');
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
           
        //$color  = "#D9EDF7";
      //  $resultado = $prueba->getDatos('1');                                                           
        return new ViewModel();
    }
   //////////////////////////////////////////////////////////////////////// NOTAS                                         
    public function notasAction()
    
    {   //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name); 
        //Instancias
        $nota = new NotaMantTable($this->dbAdapter);
        $cicl = new CicloAdminTable($this->dbAdapter);
        //Obtenemos Notas
        $notas = $nota->getNotas();
        //Obtenemos dia de cierre y calculamos restantes        
        $cierre = $cicl->getCiclo();        
            if(date('j')>$cierre[0]['dia']){
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
                $dif = ($dias_mes-date('j'))+$cierre[0]['dia']; 
                $mes_cierre =  date('F', strtotime('+1 month')) ;               
            }else{
                 $dif = $cierre[0]['dia']-date('j');    
                 $mes_cierre = date('F');        
            }
        //Fecha mes administrativo
          $descr_cierre = "Pr\u00f3ximo fin mes administrativo :  ".$cierre[0]['dia']." de ".$mes_cierre." de ".date('Y');                            
        //Retornamos a la vista
        $result = new ViewModel(array('notas'=>$notas,'dif'=>$dif,'cierre'=>$descr_cierre));            
        $result->setTerminal(true);        
        
        return $result;
    }
    /*
    public function modalnotasAction()    
    {    
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Obtemos datos POST       
        $id = $_POST['id'];
            //Validamos si es nueva nota
            if ($id>0){
                //Obtenemos nota de BBDD
                $nota = new NotaMantTable($this->dbAdapter); 
                $notas = $nota->getNotaId($id);        
                //Habilitamos boto eliminar           
                $displayelim = "";                              
            }else{
                $displayelim = "disabled";  
                $notas[0] = array('id'=>'0');
                }                                                               
                        
        $result = new ViewModel(array('displayelim'=>$displayelim,'notas'=>$notas));            
        $result->setTerminal(true);        
        
        return $result;
    }
    
    public function eliminanotaAction()
    {   
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instancias
        $nota = new NotaMantTable($this->dbAdapter);
        $id = $_POST['id'];
        //Consultamos Notas
        $nota->eliminaNota($id);
        
        $descripcion = "Nota eliminada del sistema";
        $result = new JsonModel(array('status'=>'ok','descripcion'=>$descripcion));
        $result->setTerminal(true);        

        return $result; 
        
        
    }
    public function guardanotaAction()
    {   
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instancias
        $nota = new NotaMantTable($this->dbAdapter);
        //Obtenemos datos POST
        $lista = $this->request->getPost();
        //Cargamos user_create
        $lista['user_create'] = $sid->offsetGet('id_usuario');
        //Validamos si es Insert o Update
            if ($lista['id']>0){                 
                 $nota->updateNota($lista);
                 $descripcion = "Cambios guardados";              
            }else{
                 $nota->nuevaNota($lista);
                 $descripcion = "Nueva nota igresada del sistema";
            }
        
        
        //Devolmemos a la Vista                        
        $result = new JsonModel(array('status'=>'ok','descripcion'=>$descripcion));
        $result->setTerminal(true);        

        return $result; 
        
        
    }
    //////////////////////////////////////////////////////////////////////////////TAREAS
    public function tareasAction()
    
    {   
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('id_db');
        $modulo = $sid->offsetGet('modulo');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Armamos ruta descarga
        $ruta = '/files/db/'.$id_db.'/admin/tareas/TareasMensuales.xlsx';        
        
        
        
        $result = new ViewModel(array('tareas'=>$tareas,'rsptaOK'=>SysFnc::rspOK(),'ruta'=>$ruta));
            
        $result->setTerminal(true);        
        
        return $result;
    }
    
    public function gettareasAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Cargamos TareaTable
        $tarea = new TareaTable($this->dbAdapter);
        //Traemos todas las tareas activas
        $tareas = $tarea->getTareas();
        for($i=0;$i<count($tareas);++$i){$tareas[$i]['estado'] = ucfirst($tareas[$i]['estado']);} 
        //Devolmemos a la Vista                        
        $result = new JsonModel(array('tareas'=>$tareas));
        $result->setTerminal(true);        

        return $result;   
        
    }
    
    public function exceltareasAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $nombreComercial = $sid->offsetGet('nombreComercial');
        $id_db = $sid->offsetGet('id_db');
        $modulo = $sid->offsetGet('modulo');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        //Cargamos TareaTable
        $tarea = new TareaTable($this->dbAdapter);
        $ciclo = new CicloAdminTable($this->dbAdapter);
        
        //Obtenemos cierre administrativo
        $cierre = $ciclo->getCiclo();
        
        //Traemos todas las tareas del mes
        $tareas = $tarea->getTareasMes($this->dbAdapter,substr($cierre[0]['fecha_inicio'],0,-9),substr($cierre[0]['fecha_cierre'],0,-9));
        
        //Indicamos ruta                            
        $inputFileName = $_SERVER['DOCUMENT_ROOT'].'/files/db/'.$id_db.'/'.$modulo[0]['url'].'/tareas/TareasMensuales.xlsx';
        //Copiamos planilla
           copy($_SERVER['DOCUMENT_ROOT'].'/files/TareasMensuales.xlsx' , $inputFileName);                                               
        //Llamamos Clase PHPExcel
                            $objPHPexcel = \PHPExcel_IOFactory::load($inputFileName);
                            //Obtenemos Hoja de trabajo
                            $objWorksheet = $objPHPexcel->getActiveSheet();                            
                            //Insertamos Cabezera
                            $objWorksheet->setCellValue("D5",ucfirst($nombreComercial));
                            $objWorksheet->setCellValue("D6",date('d-m-Y'));
                            $objWorksheet->setCellValue("D7","Codigo Interno");   
                                                    
                            //Insertamos valores en celdas
                            for($i=10;$i<(count($tareas))+10;$i++){                                                               
                                $objWorksheet->setCellValue("B".$i, $tareas[$i-10]['id']);
                                $objWorksheet->setCellValue("C".$i, ucfirst($tareas[$i-10]['nombre']));
                                $objWorksheet->setCellValue("D".$i, ucfirst($tareas[$i-10]['responsable']));
                                $objWorksheet->setCellValue("E".$i, ucfirst($tareas[$i-10]['estado']));
                                $objWorksheet->setCellValue("F".$i, $tareas[$i-10]['fecha']);
                                $objWorksheet->setCellValue("G".$i, $tareas[$i-10]['pago']);
                            }
                            //Escribimos nuevamente la planilla
                            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
                            $objWriter->save($inputFileName);                     
         
        //Devolmemos a la Vista                        
        $result = new JsonModel(array('status'=>'ok'));
        $result->setTerminal(true);        

        return $result;   
        
    }
    
    public function nuevatareaAction()
    
    {            
        //Obtenemos datos POST
        $lista = $this->request->getPost();
        //Cargamos formulario        
        $form = new TareaForm("form");
        //Validamos si es insert o cargamos formulario.
            if(isset($lista['nombre'])){                              
                //Conectamos con BBDD
                $sid = new Container('base');
                $db_name = $sid->offsetGet('dbNombre');
                $this->dbAdapter=$this->getServiceLocator()->get($db_name);
                //Instancias
                $tarea = new TareaTable($this->dbAdapter);
                //Cargamos usuario
                $lista['user_create'] = $sid->offsetGet('id_usuario');
                //Insertamos tarea
                $tarea->nuevaTarea($lista);
                //Devolmemos a la Vista                        
                $result = new JsonModel(array('status'=>'ok'));
                $result->setTerminal(true);        

                return $result;
             //Validamos si viene desde Relojes                                       
            }else if (isset($lista['nombre_partida'])){
                $form->get('nombre')->setAttribute('value' ,$lista['nombre_accion']." / ".$lista['nombre_partida']);
                $form->get('nombre')->setAttribute('disabled','true');
                
                $result = new ViewModel(array('form'=>$form));            
                $result->setTerminal(true);        
        
                return $result; 
             //Validamos si viene desde Tareas 
            }else{        
                                
                $result = new ViewModel(array('form'=>$form));            
                $result->setTerminal(true);        
        
                return $result;                   
            }                            
    }
                
    
    public function editartareaAction()
    
    {   //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instancias
        $tarea = new TareaTable($this->dbAdapter);         
        //Obtenemos datos POST
        $lista = $this->request->getPost();
        
            if(isset($lista['nombre'])){
                //Cargamos usuario
                $lista['user_create'] = $sid->offsetGet('id_usuario');
                //Insertamos tarea
                $tarea->editarTarea($lista['id_pk'],$lista);
                //Devolmemos a la Vista                        
                $result = new JsonModel(array('status'=>'ok'));
                $result->setTerminal(true);        

                return $result;
            
            }else{                        
                //Obtenemos tarea a editar
                $tareas = $tarea->getTareasId($lista['id']);               
                //Cargamos formulario        
                $form = new TareaForm("form");
                
                $form->get('id_pk')->setAttribute('value' ,$tareas[0]['id']);
                $form->get('nombre')->setAttribute('value' ,$tareas[0]['nombre']);
                $form->get('urgente')->setAttribute('value' ,$tareas[0]['urgente']);
                $form->get('area_responsable')->setAttribute('value' ,$tareas[0]['area_responsable']);
                $form->get('responsable')->setAttribute('value' ,$tareas[0]['responsable']);
                $form->get('pago')->setAttribute('value' ,$tareas[0]['pago']);
                $form->get('estado')->setAttribute('value' ,$tareas[0]['estado']);
                $form->get('avance')->setAttribute('value' ,$tareas[0]['avance']);
                $form->get('fecha')->setAttribute('value' ,$tareas[0]['fecha']);
                
                $form->get('sendtarea')->setAttribute('value' ,"Editar tarea");
                
                $result = new ViewModel(array('form'=>$form));            
                $result->setTerminal(true);        
        
                return $result;
            }                             
                                        
    }
    
    public function comboresponsableAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Obtenemos Datos POST
        $lista = $this->request->getPost();
        //Instancias
        $prov = new ProveedorTable($this->dbAdapter);
        $trab = new TrabajadorTable($this->dbAdapter);
     // $comi = new ComiteTable($this->dbAdapter);             
        //Validamos 1er combo
            if($lista['area_responsable']=="proveedor"){
                $combo = $prov->getProveedoresCombo($this->dbAdapter);
            } 
            if($lista['area_responsable']=="conserje"){
                
            }
            if($lista['area_responsable']=="aseo"){
                
            } 
            if($lista['area_responsable']=="comite"){
                
            }        
        
        $result = new JsonModel($combo);                                
        return $result;
        
        
    }
        public function relojesAction()
    
    {   
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instancias
        $part = new PartidaMantTable($this->dbAdapter);
        $cicl = new CicloAdminTable($this->dbAdapter);  
        //Obtenemos Dia y Hora de cierre Administrativo
        $cierre = $cicl->getCiclo(); 
        $hora_cierre = substr($cierre[0]['hora'],0,-3);
        //Obtenemos dias de meses a usar
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $dias_mes2 = cal_days_in_month(CAL_GREGORIAN, date('n')+1, date('Y'));
        $dias_mes3 = cal_days_in_month(CAL_GREGORIAN, date('n')+2, date('Y'));
        //Horas restantes del dia        
        $dif_diaria = (24-date('G'))*3600;
            //Validamos dia y calculamos segundos restantes
            if(date('j')>$cierre[0]['dia']){               
              $dif = (((($dias_mes-date('j'))+$cierre[0]['dia'])*86400)-((24-$hora_cierre)*3600)-1)-$dif_diaria;
            }else{
              $dif = ((($cierre[0]['dia']-date('j'))*86400)+$dif_diaria) - ((24-$hora_cierre)*3600) - 1 ;  
            }                 
        //Consultamos Partidas de cada Mes
        $partidas = $part->getPartidasMes($this->dbAdapter,"Jul");
        $partidas2 = $part->getPartidasMes($this->dbAdapter,'Sep');
        $partidas3 = $part->getPartidasMes($this->dbAdapter,date('M',strtotime('+2 month',strtotime(date('M'))))); 
        //Calculamos segundos de meses proximos
        $dif2 = $dif+($dias_mes2*86400)-((24-$hora_cierre)*3600)-$dif_diaria-1;
        $dif3 = $dif+$dif2+($dias_mes3*86400)-((24-$hora_cierre)*3600)-$dif_diaria-1;
        $result = new ViewModel(array(
                                'partidas'=>$partidas,
                                'partidas2'=>$partidas2,
                                'partidas3'=>$partidas3,
                                'segundos'=>$dif,
                                'segundos2'=>$dif2,
                                'segundos3'=>$dif3
                                ));            
        $result->setTerminal(true);        
        
        return $result;
    }
    
    public function calendarioAction()
    
    {   //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);                                  
        //Instancias
        $part = new PartidaMantTable($this->dbAdapter);
        //Consultamos Partidas
        $partidas = $part->getPartidas();
        
        //Retornamos a la vista
        $result = new ViewModel(array('partidas'=>$partidas,'rsptaOK'=>SysFnc::rspOK()));            
        $result->setTerminal(true);        
        
        return $result;
    }
    
    public function editarpartidaAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name); 
        //Instancias
        $part = new PartidaMantTable($this->dbAdapter);
        //Obtenemos ID 
        $id = $_POST['id'];
        //Obtenemos partida
        $partida = $part->getPartidaId($this->dbAdapter,$id);
        //Retornamos a la vista
        $result = new ViewModel(array('partida'=>$partida,'rsptaOK'=>SysFnc::rspOK()));            
        $result->setTerminal(true);        
        
        return $result;                                        
    }
    
    public function eliminarpartidaAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name); 
        //Instancias
        $part = new PartidaMantTable($this->dbAdapter);
        //Obtenemos ID 
        $id = $_POST['id'];
        //Obtenemos partida
        $partida = $part->eliminarPartida($id); 
        //Retornamos a la vista 
        $descripcion = "Partida eliminada del sistema";               
        $result = new JsonModel(array('status'=>'ok','descripcion'=>$descripcion));                                
        return $result;
                                                
    }
    public function guardarpartidaAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name); 
        //Instancias
        $part = new PartidaMantTable($this->dbAdapter);
        //Obtenemos datos POST
        $lista = $this->request->getPost();
            //Validamos post 
            if (isset($lista['categoria'])){             
                //Retornamos formulario a la vista
                $result = new ViewModel(array('categoria'=>$categoria,'rsptaOK'=>SysFnc::rspOK()));            
                $result->setTerminal(true);        
        
                return $result;
            }else{
                //Guardamos partida  
                $partida = $part->guardarPartida($lista);        
            }
            
        
        
        
        
        //Retornamos a la vista 
        $descripcion = "Cambios guardados exitosamente...";               
        $result = new JsonModel(array('status'=>'ok','descripcion'=>$descripcion));                                
        return $result;
        
        
    }
    public function inventarioAction()

    {   
        
        $result = new ViewModel();
        $result->setTerminal(true);        
        
        return $result;

    }
    
    public function getinventarioAction()
    {        
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instancias
        $invt = new InventarioTable($this->dbAdapter);
        //Obtenemos elementos del inventario
        $inventario = $invt->getDatos();
        //Retornamos a la vista
        $result = new JsonModel(array('inventario'=>$inventario));
        $result->setTerminal(true);        
        
        return $result;
    }            
    
    public function nuevoactivoAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Obtenemos datos POST
        $data = $this->getRequest()->getPost();
            if(isset($data['nombre'])){
                //Instancias
                $invt = new InventarioTable($this->dbAdapter);
                //Quitamos formato a valor 
                $data['valor'] = str_replace( ".", "", $data['valor']);                                                           
                //Insertamos nuevo activo
                $invt->nuevoActivo($data);                                                
                //Retornamos a la vista 
                $descripcion = "Nuevo activo ingresado al sistema...";               
                $result = new JsonModel(array('status'=>'ok','descripcion'=>$data));                                
                return $result;                
            }else{ 
        //Instancias
        $fond = new FondosTable($this->dbAdapter);                                
        //Cargamos formulario        
        $form = new ActivoForm("form");
        //Cargamos combo de Fondos
        $fondos = $fond->getCombo();
        $form->get('id_fondo')->setAttribute('options' ,$fondos);
        
        $result = new ViewModel(array('form'=>$form));
        $result->setTerminal(true);

        return $result; 
            }
    }
    
    public function editaractivoAction()
    {
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Obtenemos datos POST
        $data = $this->getRequest()->getPost();
        //Instancias
        $invt = new InventarioTable($this->dbAdapter);
        $fond = new FondosTable($this->dbAdapter);
        $prov = new ProveedorTable($this->dbAdapter);
        $form = new ActivoForm("form");
            if ($data['id_pk']>0){                                
                //Guardamos en BBDD                
                $invt->editarActivo($data['id_pk'],$data);
                //Retornamos a la vista
                $descripcion = 'Cambios guardados exitosamente';
                $result = new JsonModel(array('status'=>'ok','descripcion'=>$descripcion));
                $result->setTerminal(true);

                return $result;
            }
        //Obtenemos activo con id
        $activo = $invt->getActivoId($data['id']);
        //Obtenemos datos de combos
        $fondo = $fond->getFondoId($activo[0]['id_fondo']);        
        $combo = array($fondo[0]['id']=>$fondo[0]['nombre']);
            //Cargamos combo proveedor
            if($activo[0]['area_responsable']=="proveedor"){
              $proveedores =  $prov->getProveedoresCombo($this->dbAdapter);
              $form->get('responsable')->setAttribute('options',$proveedores);
              $value = array_search($activo[0]['responsable'], $proveedores);
              $form->get('responsable')->setAttribute('value' ,$value);              
            }          
        //Cargamos codigo interno del inventario
        $activo[0]['codigo_interno'] = "10".$activo[0]['id']*2;
        //Cargamos formulario
        $form->get('id_pk')->setAttribute('value' ,$activo[0]['id']);
        $form->get('nombre')->setAttribute('value' ,$activo[0]['nombre']);
        $form->get('id_fondo')->setAttribute('options' ,$combo);
        $form->get('valor')->setAttribute('value' ,$activo[0]['valor']);
        $form->get('cantidad')->setAttribute('value' ,$activo[0]['cantidad']);
        $form->get('area_responsable')->setAttribute('value' ,$activo[0]['area_responsable']);        
        $form->get('estado')->setAttribute('value' ,$activo[0]['estado']);
        $form->get('factura')->setAttribute('value' ,$activo[0]['factura']);
        $form->get('fecha')->setAttribute('value' ,$activo[0]['fecha']);
        $form->get('send')->setAttribute('value' ,"Editar activo");
        $form->get('marca')->setAttribute('value' ,$activo[0]['marca']);
        $form->get('modelo')->setAttribute('value' ,$activo[0]['modelo']);
        $form->get('nmro_serie')->setAttribute('value' ,$activo[0]['nmro_serie']);
        $form->get('ubicacion')->setAttribute('value' ,$activo[0]['ubicacion']);
        $form->get('observacion')->setAttribute('value' ,$activo[0]['observacion']);
        
                
        //Retornamos a la vista
        $result = new ViewModel(array('form'=>$form,'activo'=>$activo,));
        $result->setTerminal(true);        
        
        return $result;
        
        
    }*/
    
  }         