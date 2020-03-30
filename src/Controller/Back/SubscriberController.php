<?php
/**
 * Created by PhpStorm.
 * User: GHOUFA Zouhayer Amine
 * Date: 30/03/20
 * Time: 00:59
 */

namespace App\Controller\Back;


use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SubscriberController extends AbstractController
{

    /**
     * @Route("/subscriber", name="subscriber_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('subscriber/index.html.twig');
    }
}