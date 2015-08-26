<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Curso\MainBundle\Entity\Producto;
use Curso\MainBundle\Entity\Ciudad;
use Curso;

class ProductoController extends Controller
{

    public function altaAction($precio,$nombre){
    	//Creo el objeto de la entidad y lleno sus atributos
   		$prod=new Producto();
   		$prod->setNombre($nombre);
   		$prod->setPrecio($precio);
   		//Genero el Manager y hago la persistencia
   		$em=$this->getDoctrine()->getManager();
   		$em->persist($prod);
   		//Si no uso Flush no se guardan
   		$em->flush();
   		//Regreso la Respuesta la user
    	return new Response("<html><body>Poducto Id: ".$prod->getId()." almacenado</body></html>");
   		
   		/*$peticion=$this->get('request');
   		return new Response("<html><body>Host: ".$peticion->getMethod()."</body></html>");*/
    }
    public function actualizarAction($id,$nombre,$precio){
    	$em= $this->getDoctrine()->getManager();
    	$productos= $em->getRepository('CursoMainBundle:Producto')->find($id);
    	//Compruebo si existe ese Producto
    	if($nombre=="producto"&&$precio==15)
    		return  new Response("Actualizaste por defecto!");
    	if(!$productos)
    		throw $this->createNotFoundException("No se encontro producto id: ".$id." intente otro producto!");
    	//Asino los nuevos nombre y precios
    	else{
    	$productos->setNombre($nombre);
    	$productos->setPrecio($precio);
    	$em->flush();
    		return new Response("Actulizacion Exitosa!");
    	}
    }
    public function eliminarAction($id){
    	$em= $this->getDoctrine()->getManager();
    	$productos= $em->getRepository('CursoMainBundle:Producto')->find($id);
    	//Compruebo si existe ese Producto
    		if(!$productos)
    			throw $this->createNotFoundException("No se encontro producto id: ".$id." intente otro producto!");
    			//Elimino por id
    			else{
    				$em->remove($productos);
    				$em->flush();
    				return new Response("Eliminacion Exitosa!");
    			}
    }
    public function recuperarAction(){
    	$em= $this->getDoctrine()->getManager();
    	$productos= $em->getRepository('CursoMainBundle:Producto')->findAll();
    	$res="Productos:<br>";
    	foreach ($productos as $producto){
    		$res.=$producto->getNombre()."<br>";
    	}
    	return new Response($res);
    }
    public function getAllAction(){
    	$em= $this->getDoctrine()->getManager();
    	$productos= $em->getRepository('CursoMainBundle:Producto')->findAll();
    	// ciudades
    	$em= $this->getDoctrine()->getManager();
    	$ciudades= $em->getRepository('CursoMainBundle:Ciudad')->findAll();
    	return $this->render("CursoMainBundle:Default:mivista.html.twig",array("productos"=>$productos,"ciudades"=>$ciudades));
    }
    public function recuperarIdAction($id){
    	$em= $this->getDoctrine()->getManager();
    	$producto= $em->getRepository('CursoMainBundle:Producto')->findOneById($id);
    	$res="Productos:<br>";
    	return new Response(
    			$producto->getNombre().' ---- $ '.$producto->getPrecio()
    			);
      /*$productos= $em->getRepository('CursoMainBundle:Producto')->findBy(
        array(
                'nombre' => 'leche')
        );
      $res="Productos:<br>";
      foreach ($productos as $producto){
        $res.=$producto->getId()."---- $ ".$producto->getPrecio()."<br>";
      }
      return new Response($res);*/
    }
	public function indexAction(){
		return $this->render('CursoMainBundle:Default:mifor.html.twig');
	}
}