<?php

namespace MyOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@MyOrder/Default/index.html.twig');
    }
}
