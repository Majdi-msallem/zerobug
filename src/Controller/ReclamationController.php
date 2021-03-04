<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    /**
     * @Route("/afficherreclamation", name="afficherreclamation")
     */
    public function afficherReclamationAction() : Response
    {
        $reclamations=$this->getDoctrine()->getRepository(Reclamation::class);
        $liste=$reclamations->findAll();
        return $this->render('reclamation/afficherReclamation.html.twig',
            ['reclamation'=>$reclamations]);
    }

    /**
     * @Route("/ajouterreclamation", name="ajouterreclamation")
     */
    public function ajouterReclamationAction(Request $request)
    {

        $reclamations =new reclamation();
        $form =$this->createForm(ReclamationType::class, $reclamations);
        $form =$form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamations);
            $em->flush();

        }
        return $this->render('reclamation/ajouterReclamation.html.twig',  [
            "form_title" => "Ajouter une reclamation",
            "form_reclamation" => $form->createView(),
        ]);
    }

    public function modifierReclamationAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $e=$em->getRepository('reclamationBundle:reclamation')->find($id);
        $form=$this->createForm(reclamationType::class,$e);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($e);
            $em->flush();
            return $this->redirectToRoute("afficherReclamation");
        }
        return $this->render('@reclamation/view/modifierReclamation.html.twig', array('f'=>$form->createView()));
    }
    public function supprimerReclamationAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $reclamations= $em->getRepository(reclamation::class)->find($id);
        $em->remove($reclamations);
        $em->flush();
        return $this->redirectToRoute("afficherReclamation");
    }

}
