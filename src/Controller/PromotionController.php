<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends AbstractController
{
    /**
     * @Route("/promotion", name="promotion")
     */
    public function readPtomotion(): Response
    { $repo=$this->getDoctrine()->getRepository(Promotion::class);
    $listePromo=$repo->findAll();

    return $this->render('promotion/index.html.twig',[
        'promotion'=>$listePromo]);

    }
    /**
     * @Route("/promotion/ajouter", name="ajouterpromotion")
     */
    public function createPromotion(Request $request)
    {
        $promotion=new Promotion();
        $form=$this->createForm(PromotionType::class);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

        }

        return $this->render('promotion/ajouter.html.twig',[
            'form'=>$form->createView()]);

    }
    /**
     * @Route("/promotion/update/{idpromotion}")
     */
    public function updatePromotion(Request $idpromotion,$req){
        $repo=$this->getDoctrine()->getRepository(Promotion::class);
        $promo=$repo->find($idpromotion);
        $form=$this->createForm(PromotionType::class,$promo);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute(promotion);
        }
        return $this->render('promotion/index.html.twig',[
            'form'=>$form->createView()]);
    }

/**
 * @Route("/promotion/delete/{idpromotion}")
 */
public function deletePromotion(Request $idpromotion){
    $repo=$this->getDoctrine()->getRepository(Promotion::class);
    $promo=$repo->find($idpromotion);
    $em=$this->getDoctrine()->getManager();
    $em->remove($promo);
    $em-flush();

    return $this->redirectToRoute(promotion);

}
}
