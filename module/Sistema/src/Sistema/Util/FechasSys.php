<?php
namespace Sistema\Util;

class FechasSys {

	public static function getInicioMes($dia,$hora,$minutos)
	{      
           
        $fecha =  new \DateTime();     
        $segundos  = '00';      
            if(date('j')>$ciclo[0]['dia']){
                //Construimos fecha con mes anterior
                if(date('m')=='01')
                {
                        $año=date('Y',strtotime('-1 year'));
                }else{
                        $año=date('Y');
                }
                $mes = date('m',strtotime('-1 month'));                                                                                      
            }else{   
                //Construimos fecha con mes actual
                if(date('m')=='01')
                {
                        $año=date('Y',strtotime('-1 year'));
                }else{
                        $año=date('Y');
                }
                $mes = date('m');                
                
            }
            $fecha->setDate($año,$mes,$dia);
            $fecha->setTime($hora,$minutos,$segundos);        
       
		return $fecha;
	}
    
	
}