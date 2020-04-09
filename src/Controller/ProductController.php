<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    public function createProduct(): Response{
      $entityManager = $this->getDoctrine()->getManager();

      $product = new Product();
      $product->setName("Small World");
      $product->setPrice("35.50");
      $product->setPlayers(5);
      $product->setAge(3);
      $product->setDescription("some random text");

      $entityManager->persist($product);

      $entityManager->flush();

      return new Response('Save new product with id'.$product->getId().'and name:'.$product->getName());
    }
    public function show($id){
      $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

      if (!$product){
        throw $this->createNotFoundException('No product fonud for id'. $id);
      }

      return new Response('Check out this great product'.$product->getName());
    }
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
