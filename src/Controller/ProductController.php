<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Componeny\HttpFoundation\RedirectResponse;

class ProductController extends AbstractController{

  public function deleteProduct($id){

    $entityManager = $this->getDoctrine()->getRepository(Product::class);

    $product = $entityManager->find($id);

    if(!$product){
      throw $this->createNotFoundException( 'No product found for id '. $id);

    }

    $this->getDoctrine()->getManager()->remove($product);
    $this->getDoctrine()->getManager()->flush();

    return $this->redirectToRoute('app_main_controller');
  }
  public function showProduct($id){
    $entityManager = $this->getDoctrine();

    $product = $entityManager->getRepository(Product::class)->find($id);

    if(!$product){
      throw $this->createNotFoundException( 'No product found for id '. $id);

    }
    return new Response("Prodcut ".$id." name:".$product.getName());
  }

}
