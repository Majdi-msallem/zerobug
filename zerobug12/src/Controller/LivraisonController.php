<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livraison;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\LivraisonformType;
use Dompdf\Dompdf;
use Dompdf\Options;
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
     * @Route("/afficher1", name="afficher1")
     */
    public function afficher()
    {
        $livraison = $this->getDoctrine()->getRepository(livraison::class)->listOrderByDate();;

        return $this->render('Livraison/read.html.twig', ["livraison" => $livraison ]);
    }
    /**
     * @Route("/afficher", name="afficher")
     */
    public function afficherNom()
    {
        $livraison = $this->getDoctrine()->getRepository(livraison::class)->listOrderByNom();;

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
    /**
     * @Route("/imprimer", name="livraison_liste")
     */
    public function listel()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $livraison = $this->getDoctrine()->getRepository(livraison::class)->findAll();



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Livraison/test.html.twig', ["livraison" => $livraison]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);


    }



}
