<?php

namespace Sellermania\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Home controller.
 *
 */
class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('SellermaniaTestBundle::index.html.twig', array());
    }

}
