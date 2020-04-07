<?php

namespace App\Controller;

use Symfony\Component\HttpFundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController{

  public function main(){


    return $this->render('main/main.html.twig',
    [ 'test' => '',
    ]
    );
  }
  /**
  * @Route("/blog",name="main_list")
  */
  public function list($id){
      return $this->render('main/main.html.twig',[
        'test' => $id,
      ]);
  }

}
