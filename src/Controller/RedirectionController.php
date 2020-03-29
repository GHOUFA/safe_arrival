<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 14/03/19
 * Time: 12:09
 */

namespace App\Controller;
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RedirectionController extends Controller
{
    /**
     * @Route("/centre", name="centre_page")
     */
    public function indexAction(Request $request)
    {
        return $this->render('centre.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route ("/candidat" , name="candidat_page")
     */

    public function organisationPageAction(){

        return $this->render('candidat.html.twig');

    }
}