<?php

namespace Doc\RelBundle\Controller;

use Doc\RelBundle\Entity\Category;
use Doc\RelBundle\Entity\Product;
use Doc\RelBundle\Entity\Autor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        //$category = new Category();
        //$category->setName('Cereal');

        $product = new Product();
        $product->setName($name);
        $product->setPrice(19.99);
        $product->setDescription('Nuevo');
        // relaciona este producto con una categoría
        $product->setCategory($prod=$this->getDoctrine()->getRepository('DocRelBundle:Category')->find(9));

        $em = $this->getDoctrine()->getManager();
        //$em->persist($category);
        $em->persist($product);
        $em->flush();

        return new Response('Ingresado');
        //return $this->render('DocRelBundle:Default:index.html.twig');
    }
    public function getAction($id){
        $prod=$this->getDoctrine()->getRepository('DocRelBundle:Product')->find($id);
        return new Response(''.$prod->getCategory()->getId());
    }
    public function get3Action($id){
            $product = $this->getDoctrine()
                ->getRepository('DocRelBundle:Product')
                ->findOneByIdJoinedToCategory($id);

            $category = $product->getCategory();
        return new Response(''.$category->getName());

    }
    public function get2Action($id){
        $prod=$this->getDoctrine()->getRepository('DocRelBundle:Category')->find($id);
        //Para Obtener todos los productos de una categoria
        $cat=$prod->getProducts();
        foreach($cat as $c)
        {
            echo"".$c->getCategory()->getName();
        }
        return new Response('');
    }
    public function validAction(){
        $aut=new Autor();
        $aut->setGenero('Ficcion');
        $validator = $this->get('validator');
        $errors = $validator->validate($aut);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return $this->render('DocRelBundle:Default:val.html.twig', array(
                'errors' => $errors,
            ));
            //return new Response($errorsString);
        }
        return new Response('Tu genero favorito es '.$aut->getGenero());
    }
}
