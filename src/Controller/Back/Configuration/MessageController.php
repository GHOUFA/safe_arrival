<?php

namespace App\Controller\Back\Configuration;

use App\Entity\ConfigMessage;
use App\Form\ConfigMessageType;
use App\Repository\ConfigMessageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;


class MessageController extends AbstractController
{
    /**
     * @var TranslatorInterface $translator
     */
    protected $translator;

    /**
     * MessageController constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    /**
     * @Route("/message", name="config_message_index", methods={"GET"})
     */
    public function index(ConfigMessageRepository $configMessageRepository): Response
    {
        return $this->render('config_message/index.html.twig', [
            'config_messages' => $configMessageRepository->findAll(),
        ]);
    }
    /**
     * @Route("/message/new", name="config_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $configMessage = new ConfigMessage();
        $form = $this->createForm(ConfigMessageType::class, $configMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($configMessage);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->translator->trans('message.flash.add')
            )
            ;
            return $this->redirectToRoute('config_message_index');
        }

        return $this->render('config_message/new.html.twig', [
            'config_message' => $configMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/message/{id}/show", name="config_message_show", methods={"GET"})
     */
    public function show(ConfigMessage $configMessage): Response
    {
        return $this->render('config_message/show.html.twig', [
            'config_message' => $configMessage,
        ]);
    }

    /**
     * @Route("/message/{id}/edit", name="config_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ConfigMessage $configMessage): Response
    {
        $form = $this->createForm(ConfigMessageType::class, $configMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('config_message_index');
        }

        return $this->render('config_message/edit.html.twig', [
            'config_message' => $configMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="config_message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ConfigMessage $configMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$configMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($configMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('config_message_index');
    }
}
