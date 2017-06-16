<?php

namespace Sig\FichasocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SigFichasocialBundle:Default:index.html.twig', array('name' => $name));
    }
}
