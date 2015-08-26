<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Curso\MainBundle\Entity\Producto;

class FerController extends Controller
{
    public function indexAction($name,$lastname,$color)
    {
        return new Response("sos $name $lastname y tu color: $color desde index");
    }
    public function infoAction($pagina){
    	//return new Response("<html><body>Tu nombre ".$pagina."</body></html>");
    	if($pagina=="quienes_somos")
    		//Saco la ruta de mi routing.yml
    		return $this->redirect($this->generateUrl("informacion",array('slug'=> "paraquien")));
    		//return $this->redirect("https://www.google.com.sv/#q=Fernando");
    	if($pagina=="quien"||$pagina=="paraquien")
    		return $this->render("CursoMainBundle:Default:".$pagina.".html.twig", array());
    	else 
    		throw  $this->createNotFoundException("Pagina no Encontrada");
    }
    public function respuestaAction($op){
    	/*
    	if($op=="redirect")
    		return $this->redirect($this->generateUrl('mensaje',array('name'=>"Fernando",'lastname'=>"Bolanos",'color'=>"rojo")));
    	else 
    	if ($op=="forward"){
    		//Aqui provando una subpeticion  jaja
    		$res=$this->forward('CursoMainBundle:Fer:index',array('name'=>"Fer",'lastname'=>"Bolanos",'color'=>"azul"));
    		return $res;
    	}
    	else return new Response("Hola");
    	*/
    	return $this->render("CursoMainBundle:Default:mifor.html.twig",array('dato'=>"Hola"));
	}
	public function sesionAction(){
		$session = new Session();
		$session->start();
		
		// establece y obtiene atributos de sesión
		$session->set('name', 'Ferdi');
		return new Response("User: ".$session->get('name')." y tu Id de sesion: ".$session->migrate());
	}
	public function formularioAction(){
		// crea una Producto y le asigna algunos datos ficticios para este ejemplo
		/*$prod = new Producto();
		$prod->setNombre("Avena");
		$prod->setPrecio(1);
		$form = $this->createFormBuilder($prod)
		*/
		$form = $this->createFormBuilder()
		->add('Nombre', 'text')
		->add('Precio', 'integer')
		->add('Guardar', 'submit')
		->getForm();
		
		return $this->render('CursoMainBundle:Form:index.html.twig', array(
				'formulario' => $form->createView(),
		));
		
		//return $this->render('CursoMainBundle:Form:index.html.twig');
	}
}
