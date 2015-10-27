<?php



namespace Usuario\Controller;



use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Session\Container;

use Sistema\Model\Entity\ReclamoTable;
use Sistema\Model\Entity\TipoAsuntoTable;
use Sistema\Model\Entity\UnidadTable;
use Sistema\Model\Entity\UsuarioTable;
use Conserje\Form\ReclamoForm;



class ReclamoController extends AbstractActionController

{

    

    public function indexAction()

    {
        $this->layout('layout/usuario');
         $this->layout()->reclamo = "active";
         $this->layout()->reclamoprincipal = "active";   
        return new ViewModel();

    }



    

    public function nuevoAction()

    {
        $this->layout('layout/usuario');
        $this->layout()->reclamo = "active";
        $this->layout()->reclamonuevo = "active";   

        //Conectamos con BBDD
        $sid = new Container('base');
        $db_name = $sid->offsetGet('dbNombre');
        $this->dbAdapter=$this->getServiceLocator()->get($db_name);

        $reclamo = new ReclamoTable($this->dbAdapter);

		

        

        //id =0 [Insertar  Reclamo] 

        // id > 0 [Actualizar Reclamo]

         $id = (int) $this->params()->fromRoute('id', 0);

         

         if($this->getRequest()->isPost()){

            

            

            $lista = $this->request->getPost();

            //valor fijo, debe ser dinamico o recuperado de la sesion

            $lista['id_usuario'] ='1';

            $id_pk = (int)$lista['id_pk'];

            //Inserta o Actualizar Reclamo

           

            

           

            if($id_pk>0)

            {

                $reclamo->actualizarReclamo($id_pk,$lista);

            }else{

                           

               $reclamo->nuevoReclamo($lista);

            }

             

            return $this->forward()->dispatch('Usuario\Controller\Reclamo',array('action'=>'respuesta'));

            //return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/conserje/reclamo/consultar');



        }else{

            

            $form=new ReclamoForm("form");

            

           

            //cargamos el combobox de dpto   
            $sid = new Container('base');
            $usuario_id = $sid->offsetGet('id_usuario');
            $dpto=new UnidadTable($this->dbAdapter);
            $nmrodpto = $dpto->getDatosId($usuario_id);                    
            $form->get('id_dpto')->setAttribute('value' ,$nmrodpto['0']['nombre']);  
            

            //cargamod el combobox de tipo asunto

            $asunto=new TipoAsuntoTable($this->dbAdapter);

            $form->get('id_tipo_asunto')->setAttribute('options' ,array('Olores','Ruidos Molestos','Gastos Comunes'));

            

            

            if($id>0)

            {

                $titulo = "Actualizar Reclamo";

                $recuperaDatos = $reclamo->getReclamos($this->dbAdapter,$id);

                $form->get('id_pk')->setAttribute('value' ,$id);

                $form->get('id_dpto')->setAttribute('value' ,$recuperaDatos[0]['id_dpto']);

                $form->get('id_tipo_asunto')->setAttribute('value' ,$recuperaDatos[0]['id_tipo_asunto']);

                $form->get('receptor')->setAttribute('value' ,$recuperaDatos[0]['receptor']);

                $form->get('descripcion')->setAttribute('value' ,$recuperaDatos[0]['descripcion']);

                

            } else {

                $titulo = "Nuevo Reclamo";

                

            }

            

            

           

           

        }

        $valores = array('form'=>$form,'url'=>$this->getRequest()->getBaseUrl(),"titulo"=>$titulo);     

        return new ViewModel($valores);

    }

    

    public function respuestaAction()

    {

        $this->layout('layout/usuario');

        $this->layout()->reclamo = "active";

        $titulo = "Resultado";

        

        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');

        $reclamo = new ReclamoTable($this->dbAdapter);

        $mensaje = "La operacion se ha realizado satisfactoriamente";

        

        $lista = $reclamo->getReclamos($this->dbAdapter,0);

        $valores = array("titulo"=>$titulo,"mensaje"=>$mensaje,"lista"=>$lista);

        return new ViewModel($valores);

        

    }

    

    

    public function consultarAction()

    {

        $this->layout('layout/usuario');

        $this->layout()->reclamo = "active";

        $this->layout()->reclamoconsultar = "active";     

        $titulo = "Consultar";

        

        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');

        $reclamo = new ReclamoTable($this->dbAdapter);

        $lista = $reclamo->getReclamos($this->dbAdapter,0);

        //$form=new SugerenciaConsultarForm("form");

        //'url'=>$this->getRequest()->getBaseUrl()    

        

        

        $valores = array("titulo"=>$titulo,"lista"=>$lista);

        return new ViewModel($valores);

    }

     public function eliminarAction()

    {

        $id = (int) $this->params()->fromRoute('id', 0);

        $id2 = $this->params()->fromRoute('id2', "");

        if ($id > 0){

            

            //eliminar

            $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');

            $reclamo = new ReclamoTable($this->dbAdapter);

            $reclamo->eliminarReclamo($id);

        }

        if ($id2=="c"){

            return $this->forward()->dispatch('Conserje\Controller\Reclamo',array('action'=>'consultar'));

        }else{

            return $this->forward()->dispatch('Conserje\Controller\Reclamo',array('action'=>'respuesta'));

        }

    }

    public function estadisticaAction()

    {

        $this->layout('layout/usuario');

        $this->layout()->reclamo = "active";

        $this->layout()->reclamoestadistica = "active";  

           



         return new ViewModel();

    }

        public function detalleAction()

    {

            

        $id = $_POST['reclamoId'];

        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');

        $reclamo = new ReclamoTable($this->dbAdapter);

        $lista = $reclamo->getReclamos($this->dbAdapter,$id);

        

        $result = new ViewModel(array('lista'=>$lista));

        $result->setTerminal(true);



        return $result;

        

    }

    

}