<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator ,\Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //on genere le token d'activation
            $user->setActivationToken(md5(uniqid()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
//on cree le message
            $message =(new \Swift_Message('activation de votre compte'))
            ->setFrom('zerobug2021@gmail.com')
            //on attribut le destinataire
            ->setTo($user->getEmail())
            //on cree le contenu
            ->setBody(
                $this->renderView(
                    'activation/activation.html.twig' ,['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                )
                ;
     //on envoie l 'e-mail
            $mailer->send($message);


            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @route("activation/{token}",name="activation")
     */
    public function activation($token ,UserRepository $userRepo){
       //on verifie  si un utilisateur a ce token
        $user= $userRepo->findOneBy(['activation_token'=> $token]);

        //si aucun utilisateur n'existe avec ce token
        if(!$user) {
            //error 404
            throw $this->createNotFoundException('cet utilisateur n\'existe pas');
        }
        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        //on envoie un message flush
        $this->addFlash('messag','vous avez bien active votre compte');
        //on retoure a l'acceuil

return $this->redirectToRoute('article')  ;
    }

}
