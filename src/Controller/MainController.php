<?php

namespace App\Controller;

use Symfony\Component\HttpFundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController{

  public function main(){


    return $this->render('main/main.html.twing');
  }


}
