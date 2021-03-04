<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\CommandeType;
use App\Form\FactureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    /**
     * @Route("/facture", name="facture")
     */
    public function index(): Response
    {
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }

    /**
     * @Route("/factureadmin", name="readfactadmin")
     */
    public function readFactAdmin(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Facture::class);
        $listfct =$repo->findAll();

        return $this->render('admin/facture/read.html.twig', [
            'facture' => $listfct]);
    }
    /**
     * @Route("/factureadmin/ajouter", name="createfactadmin")
     */

    public function createFctAdmin (Request $req){
        $cmd=new Facture();
        $form=$this->createForm(FactureType::class,$cmd);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($cmd);
            $em->flush();
            return $this->redirectToRoute('readfactadmin');
        }
        return $this->render('admin/facture/create.html.twig', [
            'form' => $form->createView()]);

    }
    /**
     * @Route("/factureadmin/update/{id}", name="updatefactadmin")
     */

    public function updatefactureAdmin(Request $req,$id){
        $repo=$this->getDoctrine()->getRepository(Facture::class);
        $cmd=$repo->find($id);
        $form=$this->createForm(FactureType::class,$cmd);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('readfactadmin');
        }
        return $this->render('/admin/facture/update.html.twig', [
            'form' => $form->createView()]);
    }
    /**
     * @Route("/factureadmin/delete/{id}", name="deletefactadmin")
     */

    public function deleteFactureAdmin ($id){
        $em = $this->getDoctrine()->getManager();
        $cmd=$em->getRepository(Facture::class)->find($id);
        $em->remove($cmd);
        $em->flush();
        return $this->redirectToRoute('readfactadmin');
    }



}
