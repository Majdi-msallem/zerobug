<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Form\LivreurformType;
use App\Repository\LivreurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Psr7\uploadedFile;
use Symfony\Component\HttpFoundation\JsonRespImageonse;

class LivreurController extends AbstractController
{
    /**
     * @Route("/livreur", name="livreur")
     */
    public function index(): Response
    {
        return $this->render('livreur/index.html.twig', [
            'controller_name' => 'LivreurController',
        ]);
    }
    /**
     * @Route("/read", name="read")
     */
    public function read()
    {
        $livreur = $this->getDoctrine()->getRepository(livreur::class)->findAll();

        return $this->render('livreur/read.html.twig', ["livreur" => $livreur ]);
    }

    /**
     * @Route("/readCalender", name="readCalender")
     */
    public function readCalender(int $id): Response
    {
        $livreur = $this->getDoctrine()->getRepository(livraison::class)->findBy();

        return $this->render('livreur/readCalender.html.twig', ["livraison" => $livreur ]);
    }

    /**
     * @Route("/delete/{id}", name="d")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $livreur = $entityManager->getRepository(livreur::class)->find($id);
        $entityManager->remove($livreur);
        $entityManager->flush();

        return $this->redirectToRoute('read');
    }
    /**
     * @param Request $request
     * @return Response
     * @Route ("/ajout",name="ajout")
     */
    function Add(Request $request)
    {
        $livreur = new livreur();
        $form = $this->createForm(LivreurformType::class, $livreur);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $livreur->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute('read');

        }
        return $this->render('Livreur/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
        /**
         * @Route("/modifier/{id}", name="modifier")
         */
        public function modifier (Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $livreur = $entityManager->getRepository(livreur::class)->find($id);
        $form = $this->createForm(LivreurformType::class, $livreur);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $livreur->setImage($fileName);

            $entityManager->flush();
            return $this->redirectToRoute('read');
        }

        return $this->render("Livreur/modifier.html.twig", [

            "form" => $form->createView(),
        ]);



    }
    /**
     * @Route ("/rechercheLiv",name="recherche")
     */
    public function recherche(LivreurRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $Livreur=$repository->SearchName($data);
        return $this->render('livreur/read.html.twig',array('livreur'=>$Livreur));
    }

}
