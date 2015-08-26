<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CursoMainBundle:Default:index.html.twig', array('name' => $name));
    }
    public function ayudaAction($tema)
    {
    	return $this->render('CursoMainBundle:Default:ayuda.html.twig', array('tema' => $tema));
    	//return new Response("<html><body>Ayuda sobre ".$tema."</body></html>");
    }
        public function despedidaAction($saludo)
    {
    	return $this->render('CursoMainBundle:Default:ayuda.html.php', array('saludo' => $saludo));
    	//return new Response("<html><body>Salu ".$saludo."</body></html>");
    }
}
