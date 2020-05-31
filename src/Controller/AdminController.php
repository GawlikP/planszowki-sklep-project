<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Componeny\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;

class AdminController extends AbstractController{
  public function workersList(RequestStack $requestStack, Request $request){

    $request = $requestStack->getCurrentRequest();

    $workers  = $this->getDoctrine()->getRepository(User::class)->findAllWorkers();


    $context = $this->renderView('admin/workers.html.twig',['workers' => $workers, 'alert' => false]);
    $response = new Response($context);
    return $response;
  }
  public function usersList(RequestStack $requestStack, Request $request){
    $request = $requestStack->getCurrentRequest();

    $users  = $this->getDoctrine()->getRepository(User::class)->findAllUsers();


    $context = $this->renderView('admin/users.html.twig',['users' => $users, 'alert' => false]);
    $response = new Response($context);
    return $response;
  }
  public function workerEdit($id,RequestStack $requestStack, Request $request){
      $entityManager = $this->getDoctrine()->getRepository(User::class);
      $user = $entityManager->find($id);

      if(!$user){
        throw $this->createNotFoundException('No user found');
      }
      return $this->render('admin/worker.html.twig', ['worker' => $user]);
  }
  public function userEdit($id,RequestStack $requestStack, Request $request){
      $entityManager = $this->getDoctrine()->getRepository(User::class);
      $user = $entityManager->find($id);

      if(!$user){
        throw $this->createNotFoundException('No user found');
      }
      return $this->render('admin/user.html.twig', ['user' => $user]);
  }
  
  public function workerEditTry($id,RequestStack $requestStack, Request $request){
    $request = $requestStack->getCurrentRequest();
    $entityManager = $this->getDoctrine()->getRepository(User::class);
    $user = $entityManager->find($id);

    if(!$user){
      throw $this->createNotFoundException('No user found');
    }

    $nick = $request->request->get('nick');
    $password = $request->request->get('haslo');
    $email = $request->request->get('email');
    $name = $request->request->get('imie');
    $last_name = $request->request->get('nazwisko');
    if($nick != "")$user->setNick($nick);
    if($password != "")$user->setPassword($password);
    if($email != "")$user->setEmail($email);
    if($name != "")$user->setName($name);
    if($last_name != "")$user->setLastName($last_name);
    $this->getDoctrine()->getManager()->persist($product);
    $this->getDoctrine()->getManager()->flush();
      return $this->redirectToRoute('app_admin_workers');
  }
  public function workerDelete($id){

    $entityManager = $this->getDoctrine()->getRepository(User::class);

    $product = $entityManager->find($id);

    if(!$product){
      throw $this->createNotFoundException( 'No user found for id '. $id);

    }

    $this->getDoctrine()->getManager()->remove($product);
    $this->getDoctrine()->getManager()->flush();

    return $this->redirectToRoute('app_main_controller');
  }
  public function ordersList(RequestStack $requestStack,Request $request){
	  $request = $requestStack->getCurrentRequest();
	  
	  $orders  = $this->getDoctrine()->getRepository(Order::class)->findAll();

	  if(!$orders){
		throw $this->createNotFoundException('No Orders Find');
	  }
	  return $this->render('admin/order.html.twig',[ 'orders' => $orders ]);
  }
}
