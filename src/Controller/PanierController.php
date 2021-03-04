<?php

namespace App\Controller;
use App\Entity\Panier;
use App\Form\PanierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="readpanier")
     */
    public function readPanier()
    {
        $repo = $this->getDoctrine()->getRepository(Panier::class);
        $listPanier = $repo->findAll();

        return $this->render('panier/read.html.twig', [
            'panier' => $listPanier]);
    }

    /**
     * @Route("/panier/create", name="createpanier")
     */

    public function createPanier(Request $request)
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($panier);
            $em->flush();
            return $this->redirectToRoute(readpanier);
        }
        return $this->render('panier/base.html.twig', [
            'form' => $form->createView()]);

    }

    /**
     * @Route("/panier/update/{idpanier}", name="updatepanier")
     */

    public function updateArticle(Request $req, $id)
    {
        $repo = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repo->find($id);
        $form = $this->createForm(PanierType::class);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute(readpanier);
        }
        return $this->render('panier/base.html.twig', [
            'form' => $form->createView()]);
    }

    /**
     * @Route("/panier/delete/{id}", name="deletepanier")
     */

    public function deletePanier($id)
    {
        $em = $this->getDoctrine()->getManager();
        $panier=$em->getRepository(Panier::class)->find($id);
        $em->remove($panier);
        $em->flush();
        return $this->redirectToRoute('readpanadmin');
    }








    /**
     * @Route("/panieradmin", name="readpanadmin")
     */
    public function readPanieradmin()
    {
        $repo = $this->getDoctrine()->getRepository(Panier::class);
        $listPanier = $repo->findAll();

        return $this->render('admin/panier/read.html.twig', [
            'panier' => $listPanier]);
    }

    /**
     * @Route("/panieradmin/ajouter", name="createpanadmin")
     */

    public function createPanierAdmin(Request $request)
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($panier);
            $em->flush();
            return $this->redirectToRoute('readpanadmin');
        }
        return $this->render('admin/panier/create.html.twig', [
            'form' => $form->createView()]);

    }

    /**
     * @Route("/panieradmin/modifier/{id}", name="updatepanadmin")
     */

    public function updateArticleAdmin(Request $req, $id)
    {
        $repo = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repo->find($id);
        $form = $this->createForm(PanierType::class, $panier);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('readpanadmin');
        }
        return $this->render('/admin/panier/update.html.twig', [
            'form' => $form->createView()]);
    }

    /**
     * @Route("/panieradmin/supprimer/{id}", name="deletepanadmin")
     */

    public function deletePanierAdmin( $id)
    {
        $em = $this->getDoctrine()->getManager();
        $panier=$em->getRepository(Panier::class)->find($id);
        $em->remove($panier);
        $em->flush();
        return $this->redirectToRoute('readpanadmin');

    }
}
