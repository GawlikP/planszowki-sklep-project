<?php
namespace App\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Componeny\HttpFoundation\RedirectResponse;

class UserController extends AbstractController{

  public function tryRegister(RequestStack $requestStack){

      $request = $requestStack->getCurrentRequest();

      #$id = $request->request->get('id');
      $login = $request->request->get('nick');
      $password = $request->request->get('haslo');

      $entityManager = $this->getDoctrine()->getManager();

      $user = new User();
      $user.setLogin($login);
      $user.setPassword($password);

      $entityManager->persist($user);

      $entityManager->flush();
      return $this->redirectToRoute('app_main_controller');



  }
  public function show($id){
      $entityManager = $this->getDoctrine();
      $user = $entityManager->getRepository(User::class)->find($id);

      if(!$user){
        throw $this->createNotFoundException( 'No product found for id '. $id);

      }
      return new Response("Prodcut ".$id." name:".$user.getLogin());

  }

}
