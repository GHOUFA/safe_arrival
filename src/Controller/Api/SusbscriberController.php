<?php

namespace App\Controller\Api;

use App\Entity\ConfigMessage;
use App\Entity\Subscriber;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;


class SusbscriberController extends FOSRestController
{
    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;
    public function __construct(SubscriberRepository $subscriberRepository){
        $this->subscriberRepository = $subscriberRepository;
    }
    /**
     * Creates an subscribe resource
     * @Rest\Post("/api/subscribe")
     * @return Response
     */
    public function postArticle(Request $request)
    {
        $result                 = [];
        $params = $request->request->all();

        $result['isSuccess']         = true;
        $result['status']            = 1;
        $result['detail']           = "Un abonné est ajouté avec succés !";
        $prefered_number             = explode(";",$params['prefered_number']);
        if((isset($params['numero']) == false) or
           (isset($params['prefered_number']) == false) or
           (isset($params['message_id']) == false)
        ) {
            $result['isSuccess']         = false;
            $result['status']            = -1;
            $result['message'] = "required parameter are missing";
            return $this->handleView($this->view($result,  JsonResponse::HTTP_BAD_REQUEST));

        }
        $subscriber = $this->addSubscriber($params, $prefered_number);
        $result['subscriber'] = $subscriber;
        // Todo: 400 response - Invalid Input
        // Todo: 404 response - Resource not found
        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($result, Response::HTTP_CREATED);
    }

    private function addSubscriber(array $params, $prefered_number): Subscriber
    {
        $subscriber = new Subscriber();
        $repository = $this->getDoctrine()->getRepository(ConfigMessage::class);
        $message = $repository->find($params['message_id']);
        if (!$message) {
            throw new EntityNotFoundException('Message with id '.$message.' does not exist!');
        }
        $subscriber->setNumero($params['numero'])
                   ->setCreatedAt(new \DateTime())
                   ->setPreferedNumber($prefered_number)
                   ->setMessage($message);
        $this->subscriberRepository->save($subscriber);
        return $subscriber;
    }
}