<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livraison;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\LivraisonformType;
class LivraisonController extends AbstractController
{
    /**
     * @Route("/livraison", name="livraison")
     */
    public function index(): Response
    {
        return $this->render('livraison/index.html.twig', [
            'controller_name' => 'LivraisonController',
        ]);
    }
    /**
     * @Route("/affiche", name="affiche")
     */
    public function affiche()
    {
        $livraison = $this->getDoctrine()->getRepository(livraison::class)->findAll();

        return $this->render('Livraison/read.html.twig', ["livraison" => $livraison ]);
    }
    /**
     * @Route("/delet/{id}", name="b")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $livraison = $entityManager->getRepository(Livraison::class)->find($id);
        $entityManager->remove($livraison);
        $entityManager->flush();

        return $this->redirectToRoute('affiche');
    }
    /**
     * @param Request $request
     * @return Response
     * @Route ("/ajoutt", name="add")
     */
    function Add(Request $request)
    {
        $livraison = new livraison();
        $form = $this->createForm(LivraisonformType::class, $livraison);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            return $this->redirectToRoute('affiche');

        }
        return $this->render('Livraison/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/modify/{id}", name="modify")
     */
    public function modifier (Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $livraison = $entityManager->getRepository(Livraison::class)->find($id);
        $form = $this->createForm(LivraisonformType::class, $livraison);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('affiche');
        }

        return $this->render("Livraison/modifier.html.twig", [

            "form" => $form->createView(),
        ]);
    }



}
