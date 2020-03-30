<?php

namespace App\Controller\Api;

use App\Entity\ConfigMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;


class MessageController extends FOSRestController
{

    /**
     * @param Request $request
     * @Rest\Get("/api/messages", name="api_config_message")
     * @return View
     */
    public function getmessagesAction(): View
    {
        try {
            $repository = $this->getDoctrine()->getRepository(ConfigMessage::class);
            $delegations = $repository->findAll();

            return View::create($delegations, Response::HTTP_OK);


        } catch (\Exception $e){
            return new JsonResponse(['errors' => $e->getMessage()], 422);
        }
    }

    public function postalbumAction(){

    }
}
