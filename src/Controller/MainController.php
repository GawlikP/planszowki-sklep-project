<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Componeny\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;

class MainController extends AbstractController{

  public function main(RequestStack $requestStack){

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
	public function login(RequestStack $requestStack){
		return $this->redner('login/login.html.twig');
	}
  public function register(RequestStack $requestStack, Request $request){
    $session = $request->getSession();
    $allert = $session->get('error');
    $session->set('error','');
    return $this->render('login/register.html.twig',['alert' => $allert]);
  }

  public function info(RequestStack $requestStack){
    return $this->render('info/info.html.twig');
  }
  public function productView($id, RequestStack $requestStack,Request $request){

    $entityManager = $this->getDoctrine()->getRepository(Product::class);

    $product = $entityManager->find($id);
    if(!$product){
      throw $this->createNotFoundException('No product found for id'.$id);
    }

    return $this->render('product/productview.html.twig', ['product' => $product]);
  }
  public function productBuy($id,RequestStack $requestStack, Request $request){
    $requestt = $requestStack->getCurrentRequest();

    $count = $requestt->request->get('count');
    $basket = $request->cookies->get('b');
    $basket .=  $id."-".$count.",";

    $request->cookies->set('b','dupa');

    $context =  $this->redirectToRoute('app_basket_show');

    $response = new Response($context);

    $response->headers->setCookie(new Cookie('b',$basket));
    return $response;

  }

  public function basketShow(RequestStack $requestStack, Request $request){



    $basket = $request->cookies->get('b');




    return $this->render('product/basket.html.twig',
    ['basket'=>$basket]
  );
  }
}
