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



    $context =  $this->renderView('main/main.html.twig',
    [ 'test' => '', 'products' => $products,
    ]
    );
    $response = new Response($context);



    return $response;
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
  public function productEditPerform(RequestStack $requestStack){
    $request = $requestStack->getCurrentRequest();

    $id = $request->request->get('id');
    $name = $request->request->get('name');
    $price = $request->request->get('price');
    $players = $request->request->get('players');
    $age = $request->request->get('age');
    $company_name = $request->request->get('company_name');
    $ccount = $request->request->get('count');
    $description = $request->request->get('description');

    $entityManager = $this->getDoctrine()->getManager();

    $product = $entityManager->getRepository(Product::class)->find($id);
    if(!$product){
      throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }
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
  public function productEdit($id, RequestStack $requestStack,Request $request){

    $entityManager = $this->getDoctrine()->getRepository(Product::class);

    $product = $entityManager->find($id);
    if(!$product){
      throw $this->createNotFoundException('No product found for id'.$id);
    }

    return $this->render('admin/product.html.twig', ['product' => $product]);
  }
  public function productBuy($id,RequestStack $requestStack, Request $request){
    $requestt = $requestStack->getCurrentRequest();

    $count = $requestt->request->get('count');
    $basket = $request->cookies->get('b');
    $basket .=  $id."-".$count.",";



    $context =  $this->redirectToRoute('app_basket_show');

    $response = new Response($context);

    $response->headers->setCookie(new Cookie('b',$basket));
    return $response;

  }
  public function getDataFromBasket(String $basket) :array {

  $items = explode(",",$basket);
  $tems = [];

  #foreach ($items as &$item) {
  #  $i = explode("-",$item);
  #  $keys = array_keys($i);
  #  $keyone = $keys[0];
  #  $keytwo = $keys[1];
  #  if(array_key_exists($i[$keyone],$tems)){
  #    $tems[$i[$keyone]] += (int)$i[$keytwo];
  #  }else{
  #    $tems[$i[$keyone]] = (int)$i[$keytwo];
  #  }
  #}
  foreach ($items as &$item) {
    $i = explode('-',$item);
    if(!empty($i[0])){
      if(array_key_exists($i[0],$tems)){
        if(!empty($i[1]))
        $tems[$i[0]] += $i[1];
      }else{
        if(!empty($i[1]))
        $tems[$i[0]] = $i[1];
      }
    }


  }

  return $tems;

  }



  public function basketShow(RequestStack $requestStack, Request $request){
    $products = [];
    $basket = $request->cookies->get('b');
    if(!empty($basket)){
    $basket = $this->getDataFromBasket($basket);

    foreach ($basket as $key => $value) {
      $product = $this->getDoctrine()->getRepository(Product::class)->find($key);
      if($product){
      $product->setCount($value);
      array_push($products,$product);
    }
    }
    $str = '';
    $it = 0;
    foreach ($basket as $key => $value) {
      $str .= $key."-".$value.",";
    }
  }

    $context =  $this->renderView('product/basket.html.twig',
    ['products'=>$products]);

    $response = new Response($context);


    if(!empty($basket))$response->headers->setCookie(new Cookie('b',$str));


    return $response;
  }
  private function deleteFromBasket($id, $basket): string{

  $tems = $this->getDataFromBasket($basket);
    foreach ($tems as $key => $value) {
      if($key != $id)$str .= $key."-".$value.",";
    }

    return $str;
  }
  public function basketDelete($id, Request $request){

      $basket = $request->cookies->get('b');


    $context =  $this->redirectToRoute('app_basket_show');
    $response = new Response($context);

    $basket = $this->deleteFromBasket($id,$basket);

    $response->headers->setCookie(new Cookie('b',$basket));

    return $response;
  }

  public function basketChange(RequestStack $requestStack, Request $request){

    $basket = $request->cookies->get('b');
    $requestt = $requestStack->getCurrentRequest();

    $context =  $this->redirectToRoute('app_basket_show');
    $response = new Response($context);
    if(!empty($basket)){
      $tems = $this->getDataFromBasket($basket);
      foreach ($tems as $key => $value) {
        $tems[$key] = (int)$requestt->request->get($key);
      }

      $str = '';
      foreach ($tems as $key => $value) {
        $str .= $key."-".$value.",";
      }

      $response->headers->setCookie(new Cookie('b',$str));
    }
      return $response;
  }
  public function basketOrder(RequestStack $requestStack, Request $request){
    $basket = $request->cookies->get('b');
    if(!empty($basket)){
    $basket = $this->getDataFromBasket($basket);
    $cena = 0;

    foreach ($basket as $key => $value) {
      $product = $this->getDoctrine()->getRepository(Product::class)->find($key);
      if($product){
      $cena += $product->getPrice() * $value;

    }
    }
    }
    $context =  $this->renderView('basket/order.html.twig', ['cena' => $cena]);
    $response = new Response($context);

    return $response;
  }
  public function basketTryOrder(){
    return $this->redirectToRoute('app_basket_show');
  }
  public function adminOrders(){
    return $this->render('admin/order.html.twig');
  }

  public function adminUsers(){
    return $this->render('admin/users.html.twig');
  }
  public function adminUserDetails(){
    return $this->render('admin/user.html.twig');
  }
  //public function contact{ return $this->render('contact.html.twig')}
  public function forgotpass(){
    return $this->render('forgotpass.html.twig');
  }

  public function tryLogin(RequestStack $requestStack, Request $request){
    #$response->headers->setCookie(new Cookie('b',$str));
    # $response->headers->clearCookie('nameOfTheCookie');
    $token = '';
    $requestt = $requestStack->getCurrentRequest();
    $token = $request->cookies->get('token');
    if(empty($token)){
      $login =  $requestt->request->get('login');
      $password = $request->request->get('password');

      if($login == 'Admin' && $password == 'Admin'){
        $token = $login + " " +$password;
      }elseif ($login == 'Dealer' && $password == 'Dealer') {
        $token = $login + " " +$password;
      }elseif ($login == 'Customer' && $password == 'Customer') {
        $token = $login + " " +$password;
      }

      else{
        $context = $this->redirectToRoute('app_main_controller');
        $response = new Response($context);
        $response->headers->clearCookie('token');
        return $response;
      }
    }else{
      $context = $this->redirectToRoute('app_main_controller');
      $response = new Response($context);
      $response->headers->clearCookie('token');
      return $response;
    }

    $context =  $this->renderView('login/login.html.twig',['login' => $login]);
    $response = new Response($context);


    $response->headers->setCookie(new Cookie('token',$token));
    return $response;
  }
  public function loginOut(RequestStack $requestStack, Request $request){
    $context = $this->redirectToRoute('app_main_controller');
    $response = new Response($context);
    $response->headers->clearCookie('token');
    return $response;
  }



}
