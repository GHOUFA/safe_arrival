<?php
/**
 * Created by PhpStorm.
 * User: GHOUFA Zouhayer Amine
 * Date: 27/03/20
 * Time: 15:18
 */

namespace App\Controller\Back;

use App\Form\Type\RegistrationFormType;
use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class SecurityController
 *
 * @package App\Controller\Back
 * @Route("/user")
 */
class SecurityController extends AbstractController
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
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $user): Response
    {
        return $this->render('security/index.html.twig', [
            'users' => $user->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $authorization = $this->get('security.authorization_checker');
        if ((false === $authorization->isGranted('ROLE_ADMIN'))
        ) {
            $msg = "You are not allowd to access ROLE_ADMIN";
            throw new AccessDeniedException($msg);
        }
        // 1) build the form
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setEnabled(1);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->translator->trans('user.flash.add')
            )
            ;
            return $this->redirectToRoute('user_index');
        }

        return $this->render(
                'user/Inscription.html.twig',
            array('form' => $form->createView())
                       );
    }


    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/edit/{id}", name="useredit")
     *
     */
    public function editAction(Request $request, User $id)
    {
        $form = $this->createForm(RegistrationFormType::class, $id);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($id);
            $entityManager->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/create.html.twig', array(
                'form' => $form->createView(),
                'action' => 'Modifier'
            )
        );

    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/create2", name="admin_create_user")
     * @param UserManagerInterface $manager
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createUser(UserManagerInterface $manager, Request $request)
    {
        $user = $manager->createUser();
        $form = $this->createForm(User::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $manager->updateUser($user);
            $request
                ->getSession()
                ->getFlashBag()
                ->add('Create', "L'utilisateur a été ajouter avec succée");
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/create.html.twig', array(
                'form' => $form->createView(),
                'action' => 'Créer'
            )
        );
    }

    /**
     * @param \App\Entity\User                          $user
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function supprimerAction(User $user, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $current_user = $this->getUser();
            $entityManager->remove($user);
            $entityManager->flush();
            $request->getSession()->getFlashBag()
                    ->add('Error', "L'utilisateur a été supprimé avec succès");
        return $this->redirectToRoute('user_index');
    }
}