<?php

namespace SelectOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@SelectOrder/Default/index.html.twig');
    }
}
