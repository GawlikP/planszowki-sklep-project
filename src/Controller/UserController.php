<?php
namespace App\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Componeny\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserController extends AbstractController{

  public function tryRegister(RequestStack $requestStack, Request $request, ValidatorInterface $validator){

      $request = $requestStack->getCurrentRequest();

      #$id = $request->request->get('id');
      $login = $request->request->get('nick');
      $password = $request->request->get('haslo');
      $email = $request->request->get('email');
      $name = $request->request->get('imie');
      $last_name = $request->request->get('nazwisko');

      $entityManager = $this->getDoctrine()->getManager();
      $user = $this->getDoctrine()->getRepository(User::class)->findIfExist($login);
      if(empty($user)){
        $nuser = new User();
        $nuser->setNick($login);
        $nuser->setPassword($password);
        $nuser->setPermission(1);
        $nuser->setEmail($email);
        $nuser->setName($name);
        $nuser->setLastName($last_name);
	$errors = $validator->validate($nuser);
	if(count($errors) > 0){
		$session = $request->getSession();
		$session->set('error',$errors);
		return $this->redirectToRoute('app_login_register', $request->query->all());
	}
        $entityManager->persist($nuser);

        $entityManager->flush();
        return $this->redirectToRoute('app_main_controller');
      }
      $session = $request->getSession();
      $error = "User Already exist";
      $session->set('error',$error);


      return $this->redirectToRoute('app_login_register', $request->query->all());

  }
  public function tryUserRegister(RequestStack $requestStack, Request $request, ValidatorInterface $validator){
    $request = $requestStack->getCurrentRequest();

    #$id = $request->request->get('id');
    $login = $request->request->get('nick');
    $password = $request->request->get('haslo');
    $email = $request->request->get('email');
    $name = $request->request->get('imie');
    $last_name = $request->request->get('nazwisko');

    $entityManager = $this->getDoctrine()->getManager();
    $user = $this->getDoctrine()->getRepository(User::class)->findIfExist($login);
    if(empty($user)){
      $nuser = new User();
      $nuser->setNick($login);
      $nuser->setPassword($password);
      $nuser->setPermission(1);
      $nuser->setEmail($email);
      $nuser->setName($name);
      $nuser->setLastName($last_name);
      $errors = $validator->validate($nuser);
      if(count($errors) > 0){
	      $session = $request->getSession();
	      $session->set('error',$errors);
	      return $this->redirectToRoute('app_admin_users',$request->query->all());
      }
      $entityManager->persist($nuser);
      $entityManager->flush();
      return $this->redirectToRoute('app_admin_users');
    }
    $session = $request->getSession();
    $error = "User Already exist";
    $session->set('error',$error);


    return $this->redirectToRoute('app_admin_userses', $request->query->all());
  }
  public function tryWorkerRegister(RequestStack $requestStack, Request $request, ValidatorInterface $validator){
    $request = $requestStack->getCurrentRequest();

    #$id = $request->request->get('id');
    $login = $request->request->get('nick');
    $password = $request->request->get('haslo');
    $email = $request->request->get('email');
    $name = $request->request->get('imie');
    $last_name = $request->request->get('nazwisko');

    $entityManager = $this->getDoctrine()->getManager();
    $user = $this->getDoctrine()->getRepository(User::class)->findIfExist($login);
    if(empty($user)){
      $nuser = new User();
      $nuser->setNick($login);
      $nuser->setPassword($password);
      $nuser->setPermission(2);
      $nuser->setEmail($email);
      $nuser->setName($name);
      $nuser->setLastName($last_name);
      $errors = $validator->validate($nuser);
      if(count($errors) > 0){
	$session = $request->getSession();
	$session->set('error',$errors);
	return $this->redirectToRoute('app_admin_workers',$request->query->all());
      }
      $entityManager->persist($nuser);
      $entityManager->flush();
      return $this->redirectToRoute('app_admin_workers');
    }
    $session = $request->getSession();
    $error = "User Already exist";
    $session->set('error',$error);


    return $this->redirectToRoute('app_admin_workers', $request->query->all());

  }
  public function tryLogin(RequestStack $requestStack, Request $request){
    $request = $requestStack->getCurrentRequest();
    $token = '';

    $token = $request->cookies->get('token');

    $login = $request->request->get('nick');
    $password = $request->request->get('password');
    $entityManager = $this->getDoctrine()->getManager();
    $user = $this->getDoctrine()->getRepository(User::class)->findIfExist($login);
    
    if(!empty($user)){
      if ($password == $user[0]['Password']) {
        $context =  $this->renderView('login/login.html.twig',['login' => $login]);
        $response = new Response($context);
        if($user[0]['Permission'] == '1'){
          $token = $login." ".$password." "."USR";
        }
        if($user[0]['Permission'] == '2'){
          $token = $login." ".$password." "."WRK";
        }
        if($user[0]['Permission'] == '3'){
          $token = $login." ".$password." "."Admin";
        }
        $response->headers->setCookie(new Cookie('token',$token));
        return $response;
      }
      $context = $this->redirect($this->generateUrl('app_main_controller', array('login_error' => true, 'error' => $user[0]['Password'])));
      $response = new Response($context);
      $response->headers->clearCookie('token');
      return $response;
    } else{
      $context = $this->redirect($this->generateUrl('app_main_controller', array('login_error' => true)));
      $response = new Response($context);
      $response->headers->clearCookie('token');
      return $response;
    }
    $context = $this->redirect($this->generateUrl('app_main_controller', array('login_error' => true)));
    $response = new Response($context);
    $response->headers->clearCookie('token');
    return $response;
  }
  public function loginOut(RequestStack $requestStack, Request $request){
    $context = $this->redirectToRoute('app_main_controller');
    $response = new Response($context);
    $response->headers->clearCookie('token');
    return $response;
  }


}
