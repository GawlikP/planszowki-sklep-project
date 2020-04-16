<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Componeny\HttpFoundation\RedirectResponse;

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

      #$id = $request->request->get('id');
      $name = $request->request->get('name');
      $price = $request->request->get('price');
      $players = $request->request->get('players');
      $age = $request->request->get('age');
      $company_name = $request->request->get('company_name');
    #  $category = $request->request->get('category');
      $description = $request->request->get('description');

      $entityManager = $this->getDoctrine()->getManager();

      $product = new Product();
      $product->setName($name);
      $product->setPrice($price);
      $product->setPlayer($players);
      $product->setAge($age);
      $product->setCount(0);
      $product->setCompany($company_name);
    #  $product->setCategory($category);
      $product->setDescrioption($description);

      $entityManager->persist($product);

      $entityManager->flush();
        return $this->redirectToRoute('app_main_controller');
  }
	public function login(){
		return $this->redner("login/login.html.twig");
	}


}
