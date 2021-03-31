<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileUserController extends AbstractController
{
    /**
     * @Route("/user/profile", name="profile_user")
     */
    public function index(): Response
    {
        {
            $user = $this->getDoctrine()->getRepository(User::class)->findAll();
            return $this->render('profile_user/index.html.twig', array('user' => $user));
        }
    }
        /**
         * @Route("/user/update/{id}", name="update_user_profile")
         */
   public  function edit(Request $request,UserPasswordEncoderInterface $passwordEncoder, $id): Response
        {
            $user=  $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile_user');
            }

            return $this->render('profile_user/edit_profile.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

}
