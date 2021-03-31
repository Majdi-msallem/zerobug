<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class UserController extends AbstractController
{
    /**
     *
     * @Route("/22admin", name="admin_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
           $em=$this->getDoctrine()->getManager();

        $counts=$em->createQuery('SELECT COUNT(u) from App\Entity\User u')->getSingleScalarResult();

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'stat'=>compact('counts')
        ]);
    }

    /**

     * @Route("/admin/new", name="admin_user_new", methods={"GET","POST"})
     */
   public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
   {
       $this->denyAccessUnlessGranted('ROLE_ADMIN');
       $user = new User();
       $form = $this->createForm(UserType::class, $user);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {






           $user->setPassword(
               $passwordEncoder->encodePassword(
                   $user,
                   $form->get('password')->getData()
               )
           );
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($user);
           $entityManager->flush();

           return $this->redirectToRoute('admin_user_index');
       }

       return $this->render('user/new.html.twig', [
           'user' => $user,
           'form' => $form->createView(),
       ]);
   }
    /**

     * @Route("/admin/{id}", name="admin_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,UserPasswordEncoderInterface $passwordEncoder, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($roles)) {
                $roles[0] = 'ROLE_USER';
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/{id}", name="admin_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
