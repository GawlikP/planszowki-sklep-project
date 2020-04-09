<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController{

  public function main(){

    $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

    return $this->render('main/main.html.twig',
    [ 'test' => '', 'products' => $products,
    ]
    );
  }

  public function list($id){
      return $this->render('main/main.html.twig',[
        'test' => $id,
      ]);
  }

  public function addProduct(){

    return $this->render('product/createform.html.twig');
  }

  public function adProduct(RequestStack $requestStack){

      $request = $requestStack->getCurrentRequest();

      $var = $request->request->get('id');


        return new Response('<h1> '.$var.' </h1>');
  }

}
