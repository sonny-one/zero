<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Validator\File\Size;

use Sistema\Model\Entity\ReclamoTable;
use Sistema\Model\Entity\TipoAsuntoTable;
use Sistema\Model\Entity\FondoReservaTable;
use Sistema\Model\Entity\ComunidadTable;
use Sistema\Model\Entity\EdificacionTable;
use Sistema\Model\Entity\AscensorTable;
use Sistema\Model\Entity\SalonTable;
use Sistema\Model\Entity\QuinchoTable;
use Sistema\Model\Entity\LavanderiaTable;
use Sistema\Model\Entity\GimnasioTable;
use Sistema\Model\Entity\FondoOperTable;
use Sistema\Model\Entity\SeguroTable;
use Sistema\Model\Entity\CajachicaTable;
use Sistema\Model\Entity\MultaTable;
use Sistema\Model\Entity\TrabajadorTable;
use Sistema\Model\Entity\BodegaTable;
use Sistema\Model\Entity\UnidadTable;
use Sistema\Model\Entity\EstacionamientoTable;
use Sistema\Model\Entity\PersonaDetTable;

use Sistema\Model\Entity\General\DbTable;
use Sistema\Model\Entity\General\PersonaTable;
use Sistema\Model\Entity\General\UsuarioTable;
use Sistema\Model\Entity\General\UsudbTable;
use Zend\Db\Adapter\Adapter;

use Admin\Form\FondoOperForm;
use Admin\Form\FondoResForm;
use Admin\Form\GeneralForm;
use Admin\Form\EdificacionForm;
use Admin\Form\AscensorForm;
use Admin\Form\SalonForm;
use Admin\Form\QuinchoForm;
use Admin\Form\LavanderiaForm;
use Admin\Form\GimnasioForm;
use Admin\Form\SeguroForm;
use Admin\Form\CamarasForm;
use Admin\Form\CajachicaForm;
use Admin\Form\MultasForm;
use Admin\Form\ConserjeForm;

class InfocomController extends AbstractActionController

{    
    
    public function indexAction()
    
    {                                       
        $this->layout('layout/admin');        
        $titulo = "Mi condominio";                                                              
        $valores = array('titulo'=>$titulo);        
        return new ViewModel($valores);
        
    }
           
    public function generalAction()

    {   
        //Conectamos a BBDD general                                    
        $this->dbAdapter2=$this->getServiceLocator()->get('Zend\Db\Adapter');  
        //Conectamos a BBDD del condominio                     
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instancias
        $gral = new ComunidadTable($this->dbAdapter);
        $edif = new EdificacionTable($this->dbAdapter);
        $pers = new PersonaTable($this->dbAdapter2);        
        $form = new GeneralForm("form");
        $form2= new EdificacionForm("form");
        //Obtenemos Datos
        $comunidad   = $gral->getDatos(); //var_dump($comunidad);
        $edificacion = $edif->getDatos();
        $persona     = $pers->getDatosId($comunidad[0]['id_persona']);
        //Damos formato a RUT
        $persona['0']['rut'] = number_format($persona['0']['rut'],-3,"",".")."-".$persona['0']['dv'];   
        //Cargamos Formulario "General"                                     
        $form->get('id_pk')->setAttribute('value' ,$comunidad[0]['id']);     
        $form->get('nombre')->setAttribute('value' ,$persona[0]['nombre']); 
        $form->get('rut')->setAttribute('value' ,$persona[0]['rut']);        
        $form->get('direccion')->setAttribute('value' ,$persona[0]['direccion']);
        $form->get('ciudad')->setAttribute('value' ,$persona[0]['ciudad']);
        $form->get('pais')->setAttribute('value' ,$persona[0]['pais']);
        $form->get('telefono')->setAttribute('value' ,$comunidad[0]['telefono_admin']);
        $form->get('telefono2')->setAttribute('value' ,$comunidad[0]['telefono_cons']);
        $form->get('emailcom')->setAttribute('value' ,$comunidad[0]['emailcom']);
        $form->get('emailgc')->setAttribute('value' ,$comunidad[0]['emailgc']);
        $form->get('web')->setAttribute('value' ,$comunidad[0]['web']);                                                 
        
        //Cargamos Formulario "Edificacion"               
        $form2->get('id_pk')->setAttribute('value' ,$edificacion['0']['id']);
        $form2->get('departamento')->setAttribute('value' ,$edificacion['0']['departamento']);       
        $form2->get('piso')->setAttribute('value' ,$edificacion['0']['piso']);        
        $form2->get('subterraneo')->setAttribute('value' ,$edificacion['0']['subterraneo']);
        $form2->get('est_visita')->setAttribute('value' ,$edificacion['0']['est_visita']);
        $form2->get('torre')->setAttribute('value' ,$edificacion['0']['torre']);
        $form2->get('ascensor')->setAttribute('value' ,$edificacion['0']['ascensor']);
        $form2->get('salon')->setAttribute('value' ,$edificacion['0']['salon']);
        $form2->get('quincho')->setAttribute('value' ,$edificacion['0']['quincho']);
        $form2->get('piscina')->setAttribute('value' ,$edificacion['0']['piscina']);
        $form2->get('gimnasio')->setAttribute('value' ,$edificacion['0']['gimnasio']);
        $form2->get('acceso')->setAttribute('value' ,$edificacion['0']['acceso']);
        $form2->get('lavanderia')->setAttribute('value' ,$edificacion['0']['lavanderia']);                 
        
        $this->layout('layout/admin');                     
        $result = new ViewModel(array('form'=>$form,'form2'=>$form2,'url'=>$this->getRequest()->getBaseurl()));                    
        return $result;
        
        }
        
      /*  public function edificacionAction()
    {
        
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $edif = new EdificacionTable($this->dbAdapter);
        $lista = $edif->getDatos();                
        
        $datos = array(           
        
        'departamento'=>  $lista['0']['departamento'],
        'piso'=>          $lista['0']['piso'],
        'subterraneo'=>   $lista['0']['subterraneo'],   
        'est_visita'=>    $lista['0']['est_visita'],
        'torre'=>         $lista['0']['torre'],
        'ascensor'=>      $lista['0']['ascensor'],
        'quincho'=>       $lista['0']['quincho'],
        'salon'=>         $lista['0']['salon'],
        'piscina'=>       $lista['0']['piscina'],
        'gimnasio'=>      $lista['0']['gimnasio'],
        'acceso'=>        $lista['0']['acceso'],
        'lavanderia'=>    $lista['0']['lavanderia']
        );
    
        $result = new JsonModel(array(
                                    'status'=>'ok',
                                    'lista'=>$datos,               
                    ));                                

             return $result;   
        
        
    }*/


    public function guardarcomunidadAction()
        {
            //Conectamos BBDD Condominio
            $sid = new Container('base');
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            ////Conectamos BBDD General
            $this->dbAdapter2=$this->getServiceLocator()->get('Zend\Db\Adapter');
            //Instancias
            $gral = new ComunidadTable($this->dbAdapter);
            $pers = new PersonaTable($this->dbAdapter2);
            //Obtenemos datos POST
            $lista = $this->request->getPost();
            //Quitamos formato RUT
            $lista['rut'] = explode("-",$lista['rut']);
            $lista['dv']  = $lista['rut'][1];
            $lista['rut'] = str_replace(".","",$lista['rut'][0]);                                             
                //Validamos si es insert o update                       
                if($lista['id_pk']>0){
                    //
                   $comunidad = $gral->getComunidad($lista['id_pk']);
                    //Guardamos cambios en tabla comunidad                    
                    $lista['id_persona'] = $comunidad[0]['id_persona'];
                    $gral->guardarComunidad($lista['id_pk'],$lista);                                                   
                    //Actualizamos Nombre de comunidad                
                    $dbgral = new DbTable($this->dbAdapter2);                
                    $id_db = $sid->offsetGet('id_db');
                    $dbgral->actualizarDb($id_db,$lista['nombre']);                                
                    //Actualizamos Tabla Persona                    
                    $pers->editarPersona($lista['id_persona'],$lista);
                    $descripcion ="Cambios guardados satisfactoriamente";            
               }
               else{                
                    //   
                    $lista['id_persona'] = $pers->nuevaPersona($lista);
                    $gral->nuevaComunidad($lista);
                            
                        $descripcion ="Nueva Comunidad ingresada satisfactoriamente al sistema";
                }                                                                                                                                                                                                         
                $result = new JsonModel(array(
                //Devolvemos a la Vista
                                    'status'=>'ok',
                                    'descripcion'=>$descripcion,                    
                    ));   
                $result->setTerminal(true);                             
                return $result;                                                                                                                   
        }        

     public function guardaredifAction()
        {
            //Conectamos a la BBDD 
            $sid = new Container('base');
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            //Generamos Instancias
            $edif = new EdificacionTable($this->dbAdapter); 
            //Obtenemos datos POST
            $lista = $this->request->getPost();
            //Validamos si es insert o update
            $id_pk = $lista['id_pk'];                      
                if($id_pk > 0){
                    $edif->guardarEdificacion($id_pk,$lista);
                    $descripcion = "Cambios guardados satisfactoriamente";
                }else{                
                    $edif->nuevoEdif($lista);
                    $descripcion = "Informacion de Edificacion ingresada al sistema";
                }              
                                             
                $result = new JsonModel(array(
                                    'status'=>'ok',
                                    'descripcion'=>$descripcion,                    
                    ));                               

                return $result;                                                                                                 
        }      
        
        


/////////////////////////////////////////////////////////////// Unidades y Residentes

    public function residentesAction()
    {
    
        //Conectamos a BBDD Condominio                                    
        $sid = new Container('base');
        $id_db = $sid->offsetGet('id_db');
        $db_name = $sid->offsetGet('dbNombre');        
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instanticas
        $perd = new PersonaDetTable($this->dbAdapter);     
        $unid = new UnidadTable($this->dbAdapter);  
        //Consultamos tablas
        $residentes = $perd->getDatos();
        $unidades   = $unid->getUnidades();
            //Validamos si existen unidades
                if(count($unidades)<1){$warning="Se deben importar unidades al sistema antes de cargar propietarios!";}
        //Mostramos segun corresponda
            if (count($residentes)>0){$displaytablares = "none";}else{$displaytablares = "none";}        
        $ruta = '/files/db/'.$id_db.'/admin/copropietarios/Copropietarios.xlsx';
        $result = new ViewModel(array(
                                    'displaytablares'=>$displaytablares,
                                    'ruta'=>$ruta,
                                    'warning'=>$warning,
                                ));
        $this->layout('layout/admin');                
        return $result; 
            
    }
        
        public function excelpropietarioAction()
    {                        
        //Conectamos a BBDD Condominio                                    
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $id_db = $sid->offsetGet('$id_db');
        $modulo = $sid->offsetGet('modulo');        
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instanticas
        $unid = new UnidadTable($this->dbAdapter);       
        //Consultamos tablas
        $unidades = $unid->getUnidades();        
        
        //Obtenemos clase PHPExcel
            $objPHPExcel = new \PHPExcel();
            
            //Buscamos el file
            $inputFileName = $_SERVER['DOCUMENT_ROOT'].'/files/db/'.$id_db.'/'.$modulo[0]['url'].'/copropietario/Copropietario.xlsx';            
             
            //Llamamos Clase PHPExcel
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setReadDataOnly(TRUE);
            $objPHPExcel = $objReader->load($inputFileName);
            //Obtenemos Hoja de trabajo
            $objWorksheet = $objPHPExcel->getActiveSheet();

            //Insertamos valores en celdas
            for($i=3;$i<count($unidades)+3;$i++){
                $objWorksheet->setCellValue('A'.$i, $unidades[0]['nombre']);   
            }            
                                                            
            //Devolvemos algo a la vista                        
            $result = new JsonModel();
            $result->setTerminal(true);        

            return $result;    
            
        }
    
    public function unidadesAction()
    {   
        //Conectamos a BBDD Condominio                                    
        $sid = new Container('base');        
        $db_name = $sid->offsetGet('dbNombre');        
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instanticas
        $unid = new UnidadTable($this->dbAdapter);
        $bode = new BodegaTable($this->dbAdapter);
        $esta = new EstacionamientoTable($this->dbAdapter);        
        //Consultamos tablas
        $unidades = $unid->getUnidades();
        $bodegas = $bode->getBodegas();
        $estacionamientos = $esta->getEstacionamientos();
        //Mostramos segun corresponda
            if (count($unidades)>0 && count($bodegas)>0 && count($estacionamientos)>0)
            {   
                $displaytablauni = "block";
                //GRAFICO
                $chart = new \GoogChart;               
                // Data del Grafico
                $data = array(
                    'Deshabitados' => 17,
		        	'Habitados' => 319,		          	

	       	       );
                // Colores del Grafico
                $color = array(
			        '#999999',
			        '#54C7C5',
			        '#428bca',
		          );
                /* # Grafico 1 # */            
                $chart->setChartAttrs( array(
	           'type' => 'pie',
	           'title' => 'Ocupacion de Dptos',
	           'data' => $data,
	           'size' => array( 300, 150),
	           'color' => $color,               
	           ));  
              //Cargamos combos 
               $combo1 = $unid->getDatosActivos();                                           
                                        
            }else{$displaytablauni = "none";}
                        
            if (count($bodegas)>0){$displaybodegas = "none";}else{$displaybodegas = "block";}
            if (count($estacionamientos)>0){$displayestacionamientos = "none";}else{$displayestacionamientos = "block";}
            if (count($unidades)>0){$displayunidades = "none";}else{$displayunidades = "block";}            
        
        $this->layout('layout/admin'); 
        $result = new ViewModel(array('valores'=>$valores,
                                      'displaytablauni'=>$displaytablauni,
                                      'displaybodegas'=>$displaybodegas,
                                      'displayestacionamientos'=>$displayestacionamientos,
                                      'displayunidades'=>$displayunidades,
                                      'chart'=>$chart,
                                      
                                      ));
        
        return $result;
    }
    
    public function combounidadAction()
    {
            //conectamos a BBDD
            $sid = new Container('base');
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            //Instancias
            $unid = new UnidadTable($this->dbAdapter);
            $esta = new EstacionamientoTable($this->dbAdapter);
            $bode = new BodegaTable($this->dbAdapter);
            //Traemos data de combos 
            $combo1 = $unid->getDatosActivos();
            $combo2 = $esta->getDatosActivos();
            $combo3 = $bode->getDatosActivos();   
            //Retornamos a la vista                                          
            $result = new JsonModel(array(
                                        'status'=>'ok',
                                        'combo1'=>$combo1,
                                        'combo2'=>$combo2,
                                        'combo3'=>$combo3,                                                                                        
                        ));                                
            return $result;
        }
    
    public function detalleunidadAction()
    {
      
           //Obtenemos Datos de BBDD
           $sid = new Container('base');
           $db_name = $sid->offsetGet('dbNombre');
           $this->dbAdapter=$this->getServiceLocator()->get($db_name);
           //Instancias
           $unid = new UnidadTable($this->dbAdapter);
           $esta = new EstacionamientoTable($this->dbAdapter);
           $bode = new BodegaTable($this->dbAdapter);
           //Obtenemos datos POST
           $lista = $this->request->getPost();
            if($lista['flag']=='u'){$datos = $unid->getDatosId($lista['id']);}
            if($lista['flag']=='b'){$datos = $bode->getDatosId($lista['id']);}
            if($lista['flag']=='e'){$datos = $esta->getDatosId($lista['id']);}                                               
           //Respuesta JSON a la vista                                                   
           $result = new ViewModel(array('datos'=>$datos)); 
           $result->setTerminal(true);       

           return $result;                            
    }

        
    public function chmodAction()
    {
        
            //Indicamos ruta                            
            $inputFileName  = $_SERVER['DOCUMENT_ROOT'].'/files/db/1/admin/copropietarios/Copropietarios.xlsx';
            $inputFileName2 = $_SERVER['DOCUMENT_ROOT'].'/files/db/1/admin/copropietarios/Copropietarios2.xlsx';                            
            //Copiamos planilla
            $copy = copy($_SERVER['DOCUMENT_ROOT'].'/files/Copropietarios.xlsx' , $inputFileName);
            //$chmod = chmod($inputFileName, 0777); 
            
           $objPHPexcel = \PHPExcel_IOFactory::load($inputFileName);  
           $objWorksheet = $objPHPexcel->getActiveSheet();                     
           
            $objWorksheet->setCellValue('A3', "test")
                            ->setCellValue('A4', "TEST2")
                            ->setCellValue('A5', "TEST3")
                            ->setCellValue('A6', "TEST4")
                            ->setCellValue('A7', "TEST5");
                            
//            $objWorksheet->getCell('A3')->setValue('John');
            
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
            $objWriter->save($inputFileName);                                 
            //Devolvemos a la vista
            $descripcion = "Se han insertado ".$cont." ".ucfirst($flag)." al sistema.";
            $result = new JsonModel(array('status'=>'ok','descripcion'=>$inputFileName));
            $result->setTerminal(true);        

            return $result; 
        
        
    }
    public function importarAction()
    {
            //Instancias
            $sid = new Container('base');
            
            //Obtenemos datos de sesion            
            $id_db = $sid->offsetGet('id_db');
            $modulo = $sid->offsetGet('modulo');
            $db_name = $sid->offsetGet('dbNombre');
            //Obtenemos FLAG
            $flag = $_POST['flag'];
            
            //Conectamos a BBDD Condominio
            $this->dbAdapter=$this->getServiceLocator()->get($db_name); 
            
            //Instancias
            $bode = new BodegaTable($this->dbAdapter); 
            $esta = new EstacionamientoTable($this->dbAdapter);
            $unid = new UnidadTable($this->dbAdapter);            
            
            //Definimos ruta DEBE EXISTIR PREVIAMENTE
            $ruta = $_SERVER['DOCUMENT_ROOT'].'/files/db/'.$id_db.'/'.$modulo[0]['url'].'/'.$flag; 
                                 
            //Obtenemos y guardamos File    
            $file = $this->params()->fromFiles();                                
            $adapterFile = new \Zend\File\Transfer\Adapter\Http();
            $adapterFile->setDestination($ruta);
            $adapterFile->receive($file['file-0']['name']);
            
            //Buscamos el file
            $inputFileName = $ruta."/".$file['file-0']['name'];
             
            //Llamamos Clase PHPExcel
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setReadDataOnly(TRUE);
            $objPHPExcel = $objReader->load($inputFileName);
            //Obtenemos Hoja de trabajo
            $objWorksheet = $objPHPExcel->getActiveSheet();
            // Obtenemos los rangos de celdas de planilla excel
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = (\PHPExcel_Cell::columnIndexFromString($highestColumn))-1; // e.g. 5
                    
            //Cargamos Indices segun flag 
                    if ($flag=="unidades"){
                        $indices = array('nombre','piso','tipo','mts','alicuota','habitaciones','banos','estado','descripcion');
                    }
                    if ($flag=="bodegas"){
                        $indices = array('nombre','piso','mts','alicuota','estado','descripcion');
                    }
                    if ($flag=="estacionamientos"){
                        $indices = array('nombre','piso','tipo','mts','alicuota','estado','descripcion');
                    }
                    if ($flag=="propietarios"){
                        $indices = array('nombre','piso','tipo','mts','alicuota','estado','descripcion');
                    }
            //Recorremos excel                             
            for ($row = 3; $row <= $highestRow; ++$row) {                
                 
                 for ($col = 0; $col <= $highestColumnIndex; ++$col) {         
                    
                   $lista[$row][$col] = $objWorksheet->getCellByColumnAndRow($col,$row)->getValue();                                                                     
                }
                    //Agregamos indices a array 
                    error_reporting(E_ERROR);                   
                    $data = array_combine($indices,$lista[$row]);
                            if (!$data){                        
                                $result = new JsonModel(array('status'=>'error','descripcion'=>"ERROR! Archivo no corresponde a ".ucfirst($flag)));
                                $result->setTerminal(true);
                                return $result;
                            }                        
                    //Insertamos en BBDD
                    $data['user_create'] = $sid->offsetGet('id_usuario');
                    //Validamos a que tabla insertamos              
                        if ($flag=="unidades"){
                            $unid->nuevaUnidad($data);
                        }
                        if ($flag=="bodegas"){
                            $bode->nuevaBodega($data);                            
                        }
                        if ($flag=="estacionamientos"){
                            $esta->nuevoEstacionamiento($data);
                        }
                        ++$cont;                      
            }                   
            //Preparamos excel de propietarios            
            if ($flag=="unidades"){                            
                            //Indicamos ruta                            
                            $inputFileName = $_SERVER['DOCUMENT_ROOT'].'/files/db/'.$id_db.'/'.$modulo[0]['url'].'/copropietarios/Copropietarios.xlsx';
                            //Copiamos planilla
                            copy($_SERVER['DOCUMENT_ROOT'].'/files/Copropietarios.xlsx' , $inputFileName);                                                    
                            //Llamamos Clase PHPExcel
                            $objPHPexcel = \PHPExcel_IOFactory::load($inputFileName);
                            //Obtenemos Hoja de trabajo
                            $objWorksheet = $objPHPexcel->getActiveSheet();                            
                                                    
                            //Obtenemos unidades
                            $unidades = $unid->getUnidades();
                            //Insertamos valores en celdas
                            for($i=3;$i<(count($unidades))+3;$i++){                                                               
                                $objWorksheet->setCellValue("A".$i, $unidades[$i-3]['nombre']) ;
                            }
                            //Escribimos nuevamente la planilla
                            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
                            $objWriter->save($inputFileName);
            }
                                                                                                                                                                                                                                          
            //Devolvemos a la vista
            $descripcion = "Se han ingresado ".$cont." ".ucfirst($flag)." al sistema.";
            $result = new JsonModel(array('status'=>'ok','descripcion'=>$descripcion));
            $result->setTerminal(true);        

            return $result; 
            
       }


    public function creaexcelAction()
    {      
            //Obtenemos clase PHPExcel
            $objPHPExcel = new \PHPExcel();
            
            //Añadimos Propiedades
            $objPHPExcel->getProperties()->setCreator("ThinkPHP")
            ->setLastModifiedBy("Daniel Schlichtholz")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
            
            //Cambiamos titulo de hoja activa
            $objPHPExcel->getActiveSheet()->setTitle('Bodegas'); 
                                               
            //Insertamos valores en celdas
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B1', 'world!');
                                    
            //Escribimos y Guardamos excel
            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(str_replace('.php', '.xlsx', '/var/www/becheck.cl/files/MyExcel.xlsx'));
            //$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // Si queremos crear un PDF
            //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
            //$objWriter->save('/var/www/becheck.cl/files/MyExcel.xslx');
            
            //Devolvemos algo a la vista                        
            $result = new JsonModel();
            $result->setTerminal(true);        

            return $result;
    }
    
    


///////////////////////////////////////////////////////////////INSTALACIONES

        

    public function instalacionesAction()

    {             
        $form3 = new AscensorForm("form");
        $form4 = new SalonForm("form");
        $form5 = new QuinchoForm("form");
        $form6 = new LavanderiaForm("form");
        $form7 = new GimnasioForm("form");

        $valores = array('form3'=>$form3,
                         'form4'=>$form4,
                         'form5'=>$form5,
                         'form6'=>$form6,
                         'form7'=>$form7,
                         'url'=>$this->getRequest()->getBaseurl());
        $this->layout('layout/admin'); 
        $result = new ViewModel($valores);

        //$result->setTerminal(true);        
        return $result;

    }

///////////////////////////////////////////////////////////////INSTALACIONES-ASCENSOR

     public function ascensorAction()
    {     
           //Obtenemos Datos de BBDD
           $sid = new Container('base');
           $db_name = $sid->offsetGet('dbNombre');
           $this->dbAdapter=$this->getServiceLocator()->get($db_name);
           //Instancias           
           $asc = new AscensorTable($this->dbAdapter);
           $lista = $asc->getDatos();   
           //Respuesta JSON a la vista                                                   
           $result = new JsonModel(array('ascensor'=>$lista));        
           return $result;            
    }

    public function guardarascAction()       

    {

            //Obtenemos datos post                                              
            $lista = $this->request->getPost();
            //Conectamos a BBDD
            $sid = new Container('base');            
            $db_name = $sid->offsetGet('dbNombre');
            $this->dbAdapter=$this->getServiceLocator()->get($db_name);
            //Instanciamos tabla
            $asc = new AscensorTable($this->dbAdapter);
            // Validamos si es Insert o Update                      
            $id_pk = $lista['id_pk'];
                if($id_pk > 0){ 
                    $asc->actualizarAscensor($id_pk, $lista);   
                    $descripcion ="Edici&oacute;n de Ascensor exitosa";                    
                }else{                                     
                    $asc->nuevoAscensor($lista);  
                    $descripcion ="Ascensor ingresado exitosamente al sistema";        
                }                      
            $lista = $asc->getDatos();                                           
            $result = new JsonModel(array(
                                    'status'=>'ok',
                                    'descripcion'=>$descripcion,
                                    'ascensor'=>$lista,                    
                    ));                                

             return $result;                               
    }    

    

    public function detalleascAction()

    {            
        //Obtenemos datos post                                              
        $data = $this->request->getPost();
        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        //Instanciamos la tabla y obtenemos datos
        $asc = new AscensorTable($this->dbAdapter);
        $lista = $asc->getDatosid($data['ascensorId']);
            if($data['estado']=='0'){
                $titulo = "Deshabilitar Ascensor, indique detalle";    
            }else{
                $titulo = "Habilitar Ascensor, indique detalle";
            }        

        $result = new ViewModel(array(
                                'lista'=>$lista,
                                'titulo'=>$titulo,
                                'estado'=>$data['estado'],
                                'detalle'=>$lista[0]['detalle'])
                                );
        $result->setTerminal(true);
       
        return $result;        
    }

    public function cambiarestadoascAction()

    {       

        $sid = new Container('base');

        $db_name = $sid->offsetGet('dbNombre');

        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        //Obtenemos datos post

        $id = $_POST['id_pk'];

        $estado = $_POST['estado'];

        $detalle = $_POST['detalle'];

        

        //Se cambia estado 

        if($estado=='0'){$estado='1';}else{$estado='0';}                

        $asc = new AscensorTable($this->dbAdapter);

        $asc->estadoAscensor($id,$estado,$detalle);

        

        //Respuesta JSON a la vista

        $descripcion = "Cambio de Estado OK";

        $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,                                                        

                    ));                                

        return $result;           

    }

                    

     public function borrarascAction()

    {           
        $id = $_POST['id_pk'];
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        $asc = new AscensorTable($this->dbAdapter);
        $asc->borrarAscensor($id);

        $descripcion ="Ascensor eliminado del sistema";

        $result = new JsonModel(array(
                                    'status'=>'ok',
                                    'descripcion'=>$descripcion,
       ));
        return $result;        
    }

    

     ///////////////////////////////////////////////////////INSTALACIONES-SALONES

     

     public function salonAction()

    {       

           $sid = new Container('base');

           $db_name = $sid->offsetGet('dbNombre');

           $this->dbAdapter=$this->getServiceLocator()->get($db_name);

           $salon = new SalonTable($this->dbAdapter);

           $lista = $salon->getDatos();                                                             

           $result = new JsonModel(array('salon'=>$lista));        

           return $result;            

    }

    

    public function guardarsalonAction()       

    {

            //Obtenemos datos post                                              

            $lista = $this->request->getPost();            

            $sid = new Container('base');

            $db_name = $sid->offsetGet('dbNombre');

            $this->dbAdapter=$this->getServiceLocator()->get($db_name);

            

            $salon = new SalonTable($this->dbAdapter);

            // Validamos si es Insert o Update                      

            $id_pk = $lista['id_pk'];

            if($id_pk > 0){        

            $salon->actualizarSalon($id_pk, $lista);   

            $descripcion ="Edici&oacute;n de Salones exitosa";                           

            }else{                                     

            $salon->nuevoSalon($lista);  

            $descripcion ="Salon ingresado exitosamente al sistema"; 

            }          

            //$lastid = $this->dbAdapter->getDriver()->getLastGeneratedValue();           

            //$lista = $salon->getDatosid($lastid);                                     

            //$lista = $lista->toArray();  

            $lista = $salon->getDatos();          

            $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,

                                    'salon'=>$lista,                  

                    ));                                



             return $result;                               

    }  

    

    public function detallesalonAction()

    {                    

        $id = $_POST['salonId'];

        $estado = $_POST['estado'];

        $sid = new Container('base');

        $db_name = $sid->offsetGet('dbNombre');

        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        $salon = new SalonTable($this->dbAdapter);

        $lista = $salon->getDatosid($id);

        

        if($estado=='0'){

        $titulo = "Deshabilitar ".$lista[0]['nombre'].", indique detalle";    

        }else{

        $titulo = "Habilitar ".$lista[0]['nombre'].", indique detalle";

        }                

        $result = new ViewModel(array('lista'=>$lista,'titulo'=>$titulo,'estado'=>$estado));

        $result->setTerminal(true);

       

        return $result;        

    }  

    

    public function cambiarestadosalonAction()

    {       

        $sid = new Container('base');

        $db_name = $sid->offsetGet('dbNombre');

        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        //Obtenemos datos post

        $id = $_POST['id_pk'];

        $estado = $_POST['estado'];

        $detalle = $_POST['detalle'];

        

        //Se cambia estado 

        if($estado=='0'){$estado='1';}else{$estado='0';}                

        $salon = new SalonTable($this->dbAdapter);

        $salon->estadoSalon($id,$estado,$detalle);

        

        //Respuesta JSON a la vista

        $descripcion = "Cambio de Estado OK";

        $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,                                                        

                    ));                                

        return $result;           

    }                

    

     public function borrarsalonAction()

    {            

        $id = $_POST['id_pk'];

        $sid = new Container('base');

        $db_name = $sid->offsetGet('dbNombre');

        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        $asc = new SalonTable($this->dbAdapter);

        $asc->borrarSalon($id);

        

        $descripcion ="Salon eliminado del sistema";

        

        $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,

       ));

        return $result;        

    }

    

 //////////////////////////////////////////////////////////////////////////////QUINCHOS

     

    

     public function quinchoAction()

    {       

           $sid = new Container('base');

           $db_name = $sid->offsetGet('dbNombre');

           $this->dbAdapter=$this->getServiceLocator()->get($db_name);

           $quincho = new QuinchoTable($this->dbAdapter);

           $lista = $quincho->getDatos();                                                             

           $result = new JsonModel(array('quincho'=>$lista));        

           return $result;            

    }

    

    public function guardarquinchoAction()       

    {

            //Obtenemos datos post                                              

            $lista = $this->request->getPost();            

            $sid = new Container('base');

            $db_name = $sid->offsetGet('dbNombre');

            $this->dbAdapter=$this->getServiceLocator()->get($db_name);

            

            $quincho = new QuinchoTable($this->dbAdapter);

            // Validamos si es Insert o Update                      

            $id_pk = $lista['id_pk'];

            if($id_pk > 0){        

            $quincho->actualizarQuincho($id_pk, $lista);   

            $descripcion ="Edici&oacute;n de Quincho exitosa";                           

            }else{                                     

            $quincho->nuevoQuincho($lista);  

            $descripcion ="Quincho ingresado exitosamente al sistema"; 

            }           

            $lista = $quincho->getDatos();         

            $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,

                                    'quincho'=>$lista,                  

                    ));                                



             return $result;                               

    }  

    

    public function detallequinchoAction()

    {                    

        $id = $_POST['quinchoId'];

        $estado = $_POST['estado'];

        $sid = new Container('base');

        $db_name = $sid->offsetGet('dbNombre');

        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        $quincho = new QuinchoTable($this->dbAdapter);

        $lista = $quincho->getDatosid($id);

        

        if($estado=='0'){

        $titulo = "Deshabilitar ".$lista[0]['nombre'].", indique detalle";    

        }else{

        $titulo = "Habilitar ".$lista[0]['nombre'].", indique detalle";

        }                

        $result = new ViewModel(array('lista'=>$lista,'titulo'=>$titulo,'estado'=>$estado,'nombre'=>$lista[0]['nombre']));

        $result->setTerminal(true);

       

        return $result;        

    }  



    public function cambiarestadoquinchoAction()

    {       

        $sid = new Container('base');

        $db_name = $sid->offsetGet('dbNombre');

        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        //Obtenemos datos post

        $id = $_POST['id_pk'];

        $estado = $_POST['estado'];

        $detalle = $_POST['detalle'];

        

        //Se cambia estado 

        if($estado=='0'){$estado='1';}else{$estado='0';}                

        $quincho = new QuinchoTable($this->dbAdapter);

        $quincho->estadoQuincho($id,$estado,$detalle);

        

        //Respuesta JSON a la vista

        $descripcion = "Cambio de Estado OK";

        $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,                                                        

                    ));                                

        return $result;           

    }                

    

     public function borrarquinchoAction()

    {            

        $id = $_POST['id_pk'];

        $sid = new Container('base');

        $db_name = $sid->offsetGet('dbNombre');

        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        $quincho = new QuinchoTable($this->dbAdapter);

        $quincho->borrarQuincho($id);

        

        $descripcion ="Quincho eliminado del sistema";

        

        $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,

       ));

        return $result;        

    }

    

 //////////////////////////////////////////////////////////////////////////////LAVANDERIA

     

    

     public function lavanderiaAction()

    {       

           $sid = new Container('base');

           $db_name = $sid->offsetGet('dbNombre');

           $this->dbAdapter=$this->getServiceLocator()->get($db_name);

           $lav = new LavanderiaTable($this->dbAdapter);

           $lista = $lav->getDatos();                                                                                              

           $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'lav'=>$lista,

                ));

           return $result;                    

    }    

    

    

    

    public function guardarlavanderiaAction()       

    {

            //Obtenemos datos post                                              

            $lista = $this->request->getPost();            

            $sid = new Container('base');

            $db_name = $sid->offsetGet('dbNombre');

            $this->dbAdapter=$this->getServiceLocator()->get($db_name);

            

            $lav = new LavanderiaTable($this->dbAdapter);

            // Validamos si es Insert o Update                      

            $id_pk = $lista['id_pk'];

            if($id_pk > 0){        

            $lav->actualizarLav($id_pk, $lista);   

            $descripcion ="Edici&oacute;n de Lavander&iacute;a exitosa";                           

            }else{                                     

            $lav->nuevaLav($lista);  

            $descripcion ="Lavander&iacute;a ingresada exitosamente al sistema"; 

            }       

            //$lista = $lav->getDatos();         

            $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,

                                    'lav'=>$lista,                  

                    ));                                



             return $result;                               

    }                                                            

//////////////////////////////////////////////////////////////////////////////GIMNASIO

     

    

     public function gimnasioAction()

    {       

           $sid = new Container('base');

           $db_name = $sid->offsetGet('dbNombre');

           $this->dbAdapter=$this->getServiceLocator()->get($db_name);

           $gim = new GimnasioTable($this->dbAdapter);

           $lista = $gim->getDatos();                                                                                              

           $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'gim'=>$lista,

                ));

           return $result;                    

    }    

    

    

    

    public function guardargimnasioAction()       

    {

            //Obtenemos datos post                                              

            $lista = $this->request->getPost();            

            $sid = new Container('base');

            $db_name = $sid->offsetGet('dbNombre');

            $this->dbAdapter=$this->getServiceLocator()->get($db_name);

            

            $gim = new GimnasioTable($this->dbAdapter);

            // Validamos si es Insert o Update                      

            $id_pk = $lista['id_pk'];

            if($id_pk > 0){        

            $gim->actualizarGim($id_pk, $lista);   

            $descripcion ="Edici&oacute;n de Gimnasio exitosa";                           

            }else{                                     

            $gim->nuevoGim($lista);  

            $descripcion ="Gimnasio ingresado exitosamente al sistema"; 

            }       

            $lista = $gim->getDatos();       

            $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,

                                    'gim'=>$id_pk,                  

                    ));                                



             return $result;                               
    }

//                                                          *****************SEGURIDAD************                        
    public function seguridadAction()
    {      
        $form = new SeguroForm("form");
        $form2 = new CamarasForm("form");
        
        $valores = array('form'=>$form,
                         'form2'=>$form2,
                       /* 'form5'=>$form5,
                         'form6'=>$form6,
                         'form7'=>$form7,*/
                         'url'=>$this->getRequest()->getBaseurl());
        $this->layout('layout/admin');        
        $result = new ViewModel($valores);        
        
        return $result;
    }

//////////////////////////////////////////////////////////////////////////////SEGUROS



 public function seguroAction()

    {           

           $sid = new Container('base');

           $db_name = $sid->offsetGet('dbNombre');

           $this->dbAdapter=$this->getServiceLocator()->get($db_name);

           $seg = new SeguroTable($this->dbAdapter);

           $lista = $seg->getDatos();                                                                                              

           $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'seg'=>$lista,

                ));

           return $result;                    

    }    

    

    

    

    public function guardarseguroAction()       

    {

            //Obtenemos datos post  

                                                        

            $lista = $this->request->getPost();            

            $sid = new Container('base');

            $db_name = $sid->offsetGet('dbNombre');

            $this->dbAdapter=$this->getServiceLocator()->get($db_name);

            

            $seg = new SeguroTable($this->dbAdapter);

            // Validamos si es Insert o Update                      

            $id_pk = $lista['id_pk'];

            if($id_pk > 0){        

            $seg->actualizarSeguro($id_pk, $lista);   

            $descripcion ="Edici&oacute;n de Seguros exitosa";                           

            }else{                                     

            $seg->nuevoSeguro($lista);  

            $descripcion ="Seguro ingresado exitosamente al sistema"; 

            }       

            $lista = $seg->getDatos();       

            $result = new JsonModel(array(

                                    'status'=>'ok',

                                    'descripcion'=>$descripcion,

                                    'seg'=>$id_pk,                  

                    ));                                



             return $result;                               

    }
    
    //////////////////////////////////////////////////////////////////////////////Conserjes
        public function conserjeriaAction()
    {              
        //Conectamos con BBDD  
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);             
        //Abrimos Instancias    
        $tr = new TrabajadorTable($this->dbAdapter);
        $conserjeria = $tr->getDatosFull($this->dbAdapter);

        $result = new JsonModel(array(
                                    'status'=>'ok',
                                    'conserjeria'=>$conserjeria,                                                     
                    ));                                
        return $result;    
    }
    

    

    public function detalleconserjeAction()

    {

      

        $data = $this->getRequest()->getPost();

        

        $valores = $data['id'];

        $result = new ViewModel(array('valores'=>$valores));

        $result->setTerminal(true);

       

        return $result; 

    

    }
    

    



}

