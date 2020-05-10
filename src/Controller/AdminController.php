<?php
namespace App\Controller;
use App\Entity\User;
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
}
