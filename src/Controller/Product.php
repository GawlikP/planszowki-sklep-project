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

    $entityManager = $this->getDoctrine()->getManager();

    $product = $entityManager->getDoctrine()->getRepository(Product::class)->find(&id)

    if(!$product){
      throw $this->createNotFoundException( 'No product found for id '. $id);

    }

    $entityManager->remove($product);
    $entityManager->flush();

    return $this->redirectToRoute('app_main_controller');
  }

}
