<?php

namespace App\Controller\Back;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DashbordController extends AbstractController
{
    /**
     * @Route("/", name="tritux_dashbord", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('dashbord.html.twig');
    }
}
