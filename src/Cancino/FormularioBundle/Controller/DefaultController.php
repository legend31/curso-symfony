<?php

namespace Cancino\FormularioBundle\Controller;

use Cancino\FormularioBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Curso\MainBundle\Form\ProductoType;
use Symfony\Component\HttpFoundation\Request;
use Cancino\FormularioBundle\Entity\ProdForm;
use Cancino\FormularioBundle\Form\ProdFormType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
//Este es un comment

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	return new Response("Hola ".$name);
        //return $this->render('CancinoFormularioBundle:Default:index.html.twig', array('name' => $name));
    }
    public function crearFormAction(){
    	//DEde Cero
    	$form=$this->createFormBuilder()
    	->add('Nombre','text')
    	->add('Precio','integer',array('required'=>false))
    	->add('Guardar','submit')
    	->getForm();
        return $this->render('CancinoFormularioBundle:Default:index.html.twig', array(
            'formulario' => $form->createView()
        ));
    	 
    }
    public function llamarFormAction(Request $request,$nom,$pre){
    	//Aqui llamandolo despues de haberlo creado en la consola
    	$prod=new ProdForm();
    	$prod->setNombre($nom);
    	$prod->setPrecio($pre);
    	$form=$this->createForm(new ProdFormType(),$prod);
    	//Handle request detecta si el form se ha enviado
    	$form->handleRequest($request);
    	//valido el formulario
    	if($form->isValid()){
    		$em=$this->getDoctrine()->getEntityManager();
    		$em->persist($prod);
    		$em->flush();
    		//Para mandar un mensaje flash
    		$this->mensaje("Producto Agregado Exitosamente");
    		return $this->redirect($this->generateUrl('cancino_index'));
    		//return $this->forward('CancinoFormularioBundle:Default:home');
    	}
    	//Renderizo la plantilla
    	return $this->render('CancinoFormularioBundle:Default:index.html.twig',array('form'=>$form->createView()
    	));
    }
	public function homeAction(Request $request)
	{
		$session = $request->getSession();
		if ($session->has("id"))
		{
			$em = $this->getDoctrine()->getEntityManager();
			$prod = $em->getRepository('CancinoFormularioBundle:ProdForm')->findAll();
			return $this->render('CancinoFormularioBundle:Default:home.html.twig', array('producto' => $prod));
		}
		else{
			$this->mensaje("Por favor Inicie Sesion");
			return $this->redirect($this->generateUrl('cancino_form'));
		}

	}
	public function modificarAction($id,Request $request) {
		$em=$this->getDoctrine()->getEntityManager();
		$prod=$em->getRepository('CancinoFormularioBundle:ProdForm')->find($id);

		$form=$this->createForm(new ProdFormType(),$prod);
    	//Handle request detecta si el form se ha enviado
    	$form->handleRequest($request);
    	//valido el formulario
    	if($form->isValid()){
    		$em->flush();
    		$this->mensaje("Actualizacion exitosa");
    		return $this->redirect($this->generateUrl('cancino_index'));
    	}
    	//Renderizo la plantilla
		return $this->render('CancinoFormularioBundle:Default:index.html.twig',array('form'=>$form->createView()
		));
	}
	public function eliminarAction($id) {
		$em=$this->getDoctrine()->getEntityManager();
		//Recupero el objeto
		$prod=$em->getRepository('CancinoFormularioBundle:ProdForm')->find($id);
		//Le indico a Doctrine q me lo elimine
		$em->remove($prod);
		//Doctrine ejucta lo q le dije antes
		$em->flush();
		$this->mensaje("Eliminacion Exitosa");
		return $this->redirect($this->generateUrl('cancino_index'));
	}
	public function comboAction(Request $request){
		$fcon=array('nombre' => '', 'status' => '');
		$em = $this->getDoctrine()->getEntityManager();
		$prod = $em->getRepository('CancinoFormularioBundle:ProdForm')->findAll();
		$pp=array();
		$pre=array();
		$i=0;
		foreach($prod as $p){
			$pp[$i]=$p->getNombre();
			$i++;
		}
		$i=0;
		foreach($prod as $p){
			$pre[$i]=$p->getPrecio();
			$i++;
		}
		$form=$this->createFormBuilder($fcon)
			->add('nombre','text')
			/*->add('prod', 'choice', array('empty_value' => 'Producto','choice_list' => new ChoiceList($pre, $pp)
				))*/
			->add('producto', 'entity', array(
				'class' => 'CancinoFormularioBundle:ProdForm',
				'property' => 'nombre',
			))
			->add('Enviar','submit')
			->getForm();
		$form->handleRequest($request);
		if($form->isValid())
		{
			$data=$form->getData();
			return new Response(''.$data['producto']->getNombre());
		}
		else
		return $this->render('CancinoFormularioBundle:Default:combo.html.twig', array(
			'form' => $form->createView()
		));
	}
	public function formAction(Request $request){
		$user=new Usuario();
		//Sino lo quiero hacer objeto le paso este array al Builder
		//$datauser=array('email'=>'','pass','');
		//Formulario desde  Cero
		$form=$this->createFormBuilder($user)
			->add('email','email')
			->add('pass','password',array('required'=>true))
			->add('Login','submit')
			->getForm();
		$form->handleRequest($request);
		//valido el formulario
		if($form->isValid()) {
			/* Y uso esta
			$data=$form->getData();
			return new Response('Email: '.$data['email'].' y tu pass '.$data['pass']);
			*/
			//Consulto la base
			$em=$this->getDoctrine()->getEntityManager();
			$usuario=$em->getRepository('CancinoFormularioBundle:Usuario')->findOneBy(array('email'=>$user->getEmail(),'pass'=>$user->getPass()));
			if($usuario){
				//Creo la sesion
				$session=$request->getSession();
				$session->set('id',$usuario->getUserId());
				$session->set('email',$usuario->getEmail());
				return $this->redirect($this->generateUrl('cancino_index'));
				//$this->mensaje("Pudiste Acceder !".$usuario->getEmail());
			}
			else
				$this->mensaje("No pudiste Acceder !");
		}
		//Renderizo la plantilla
		return $this->render('CancinoFormularioBundle:Default:form.html.twig', array(
			'form' => $form->createView()
		));
	}
	public function logoutAction(Request $request){
		$session=$request->getSession();
		$session->clear();
		return $this->redirect($this->generateUrl('cancino_index'));

	}
	private function mensaje($m){
		$this->get('session')->getFlashBag()->add(
				'notice',
				''.$m
				);
	}
}
