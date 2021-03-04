<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
    /**
     * @Route("/commande/ajouter", name="ajouterpromotion")
     */
    public function createCommande(Request $request)
    {
        $promotion=new Commande();
        $form=$this->createForm(CommandeType::class);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

        }

        return $this->render('Commande/index.html.twig',[
            'form'=>$form->createView()]);

    }
    /**
     * @Route("/promotion/update/{idCommande}")
     */
    public function updateCommande(Request $idpromotion,$req){
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $promo=$repo->find($idpromotion);
        $form=$this->createForm(CommandeType::class,$promo);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute(promotion);
        }
        return $this->render('Commande/index.html.twig',[
            'form'=>$form->createView()]);
    }

    /**
     * @Route("/Commande/delete/{idCommande}")
     */
    public function deleteCommande(Request $idpromotion){
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $promo=$repo->find($idpromotion);
        $em=$this->getDoctrine()->getManager();
        $em->remove($promo);
        $em-flush();

        return $this->redirectToRoute(promotion);

    }









    /**
     * @Route("/commandeadmin", name="readcmdadmin")
     */
    public function readCmdAdmin(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $listCmd =$repo->findAll();

        return $this->render('admin/commande/read.html.twig', [
            'commande' => $listCmd]);
    }
    /**
     * @Route("/commandeadmin/ajouter", name="createcmdadmin")
     */

    public function createCmdAdmin (Request $req){
        $cmd=new Commande();
        $form=$this->createForm(CommandeType::class,$cmd);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($cmd);
            $em->flush();
            return $this->redirectToRoute('readcmdadmin');
        }
        return $this->render('admin/commande/create.html.twig', [
            'form' => $form->createView()]);

    }
    /**
     * @Route("/commandeadmin/update/{id}", name="updatecmdadmin")
     */

    public function updateCommandeAdmin(Request $req,$id){
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $cmd=$repo->find($id);
        $form=$this->createForm(CommandeType::class,$cmd);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('readcmdadmin');
        }
        return $this->render('/admin/commande/update.html.twig', [
            'form' => $form->createView()]);
    }
    /**
     * @Route("/commandeadmin/delete/{id}", name="deletecmdadmin")
     */

    public function deleteArticleAdmin ($id){
        $em = $this->getDoctrine()->getManager();
        $cmd=$em->getRepository(Commande::class)->find($id);
        $em->remove($cmd);
        $em->flush();
        return $this->redirectToRoute('readcmdadmin');
    }



}
