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
      $products = $this->getDoctrine()->getRepository(User::class)->findIfExist($login);
      if(empty($products)){
        $user = new User();
        $user->setNick($login);
        $user->setPassword($password);
        $user->setPermission(1);

        $entityManager->persist($user);

        $entityManager->flush();
        return $this->redirectToRoute('app_main_controller');
      }
      $error = "User Already exist";
      return $this->redirectToRoute('app_login_register', ['alert' => 'test']);

  }


}
