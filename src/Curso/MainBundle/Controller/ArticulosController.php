<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Curso\MainBundle\Entity\Articles;

class ArticulosController extends Controller
{
    public function listarAction(){
    	/*
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$articulos = $em->getRepository('CursoMainBundle:Articles')->findAll();
    	
    	return $this->render('CursoMainBundle:Articulos:listar.html.twig', array('articulos' => $articulos));
    */
    	$em = $this->getDoctrine()->getEntityManager();
    	$articulo = $em->getRepository('CursoMainBundle:Articles')->findOneById(6);
    	$comentarios = $articulo->getComments();
    	//return new Response("<html><body>".$comentarios[0]->getContent()."</body></html>");
    	return $this->render('CursoMainBundle:Articulos:listar.html.twig', array('articulos' => $comentarios));
    }
    public function crearAction()
    {
    	//Creo un articulo de ejemplo
    	$articulo = new Articles();
    	$articulo->setTitle('Articulo de ejemplo 1');
    	$articulo->setAuthor('John Doe');
    	$articulo->setContent('Contenido');
    	$articulo->setTags('ejemplo');
    	$articulo->setCreated(new \DateTime());
    	$articulo->setUpdated(new \DateTime());
    	$articulo->setSlug('articulo-de-ejemplo-1');
    	$articulo->setCategory('ejemplo');
    	//Hacemos lo de Doctrine
    	$em=$this->getDoctrine()->getEntityManager();
    	$em->persist($articulo);
    	$em->flush();
    	//return new Response("<html><body>Insertado!</body></html>");
    	return $this->render('CursoMainBundle:Articulos:articulo.html.twig', array('articulo' => $articulo));
    	 
    }

    public function editarAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$articulo = $em->getRepository('CursoMainBundle:Articles')->find($id);
    	
    	$articulo->setTitle('Articulo ej1 modificado');
    	$articulo->setUpdated(new \DateTime());
    	
    	//$em->persist($articulo);
    	$em->flush();
    	
    	return $this->render('CursoMainBundle:Articulos:articulo.html.twig', array('articulo' => $articulo));
    }
    
    public function borrarAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$articulo = $em->getRepository('CursoMainBundle:Articles')->find($id);
    	
    	$em->remove($articulo);
    	$em->flush();
    	
    	return $this->redirect(
    			$this->generateUrl('articulo_listar')
    			);
    }
    public function pruebaAction() {
    	$res=$this->listarAction();
    	return $res;
    }
}