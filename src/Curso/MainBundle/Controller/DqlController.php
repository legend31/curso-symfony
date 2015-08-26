<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Curso\MainBundle\Entity\Articles;

class DqlController extends Controller{
	public function listarAction(){
		$em=$this->getDoctrine()->getEntityManager();
		$com=$em->getRepository('CursoMainBundle:Articles')->listarId(6);
		/*foreach($com as $articulo)
		{
			$id = $articulo->getId();
			$title = $articulo->getTitle();
			echo "<br>ID: ".$id." Titulo: ".$title;
		}
		*/
    	//return $this->render("CursoMainBundle:Articulos:listar.html.twig",array('articulos'=>$com));
		return new Response("<html><body> ".$com[0]->getId()."</body></html>");
		
	}
}