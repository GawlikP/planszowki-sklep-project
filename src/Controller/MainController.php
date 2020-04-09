<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController{

  public function main(){

    $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

    return $this->render('main/main.html.twig',
    [ 'test' => '',
    ]
    );
  }
  /**
  * @Route("/blog",name="main_list")
  */
  public function list($id){
      return $this->render('main/main.html.twig',[
        'test' => $id,
      ]);
  }

}
