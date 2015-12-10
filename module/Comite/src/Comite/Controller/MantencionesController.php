<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
 
namespace Comite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

use Sistema\Model\Entity\PartidaMantTable;
use Sistema\Model\Entity\CicloAdminTable;


class MantencionesController extends AbstractActionController

{
    public function indexAction()

    {                   
        //Cargamos Layout
        $this->layout('layout/comite');
        return new ViewModel();
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
        $partidas = $part->getPartidasMes($this->dbAdapter,date('M'));
        $partidas2 = $part->getPartidasMes($this->dbAdapter,date('M'));
        $partidas3 = $part->getPartidasMes($this->dbAdapter,date('M',strtotime('+2 month',strtotime(date('M'))))); 
        //Calculamos segundos de meses proximos
        $dif2 = $dif+($dias_mes2*86400)-((24-$hora_cierre)*3600)-$dif_diaria-1;
        $dif3 = $dif+$dif2+($dias_mes3*86400)-((24-$hora_cierre)*3600)-$dif_diaria-1;
        $this->layout('layout/comite');
        $result = new ViewModel(array(
                                'partidas'=>$partidas,
                                'partidas2'=>$partidas2,
                                'partidas3'=>$partidas3,
                                'segundos'=>$dif,
                                'segundos2'=>$dif2,
                                'segundos3'=>$dif3
                                ));            
       // $result->setTerminal(true);        
        
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
        $this->layout('layout/comite');
        $result = new ViewModel(array('partidas'=>$partidas));            
        //$result->setTerminal(true);        
        
        return $result;
    }
    public function asambleaAction()
    {                   
        //Conectamos a BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);
        
        //Instancias
                 
                 
        //Obtenemos 
        $form="";
     
        //Retornamos a la vista
        $this->layout('layout/comite');
    
        return new ViewModel(array('form'=>$form));
    }
    
    
}

