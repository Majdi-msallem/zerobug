<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Psr7\UploadedFile;
use Symfony\Component\HttpFoundation\JsonRespImageonse;
class ArticleController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    /**
     * @Route ("/recherchearticle",name="recherchearticle")
     */
    public function recherche(ArticleRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $article=$repository->SearchName($data);
        return $this->render('article/affiche.html.twig',array('article'=>$article));
    }
    /**
     * @Route("/art/{id}", name="art")
     */
    public function index($id): Response
    {
        $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
        if(!$article){
            throw $this->createNotFoundException('Aucun produit ne correspond à l\' id'.$id);
        }
        return $this->render('article/index.html.twig', [
            'article' =>$article
        ]);
    }
    /**
     * @Route("/article", name="article")
     */
    public function readArticle(Request $request ): Response
    {
        $articles=$this->getDoctrine()->getRepository(Article::class)->findAll();
        $article=$this->get('knp_paginator')->paginate($articles,$request->query->getInt('page',1),9);


        return $this->render('article/Read.html.twig',array ('article' => $article
        ));
    }
    /**
     * @Route("/article/create", name="createarticle")
     */

    public function createArticle(Request $req){
        $article=new Article();
        $form=$this->createForm(ArticleType::class);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute(readarticle);
        }
        return $this->render('article/Read.html.twig', [
            'form' => $form->createView()]);

    }
    /**
     * @Route("/article/update/{id}", name="updatearticle")
     */

    public function updateArticle(Request $req,$id){
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $article=$repo->find($id);
        $form=$this->createForm(ArticleType::class,$article);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute(readarticle);
        }
        return $this->render('article/Read.html.twig', [
            'form' => $form->createView()]);
    }
    /**
     * @Route("/article/delete/{id}", name="deletearticle")
     */

    public function deleteArticle(Request $req,$id){
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->find($id);
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('panier');
        }








    /**
     * @Route("/articleadmin", name="readartadmin")
     */
    public function readArticleAdmin(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $listArticle =$repo->findAll();

        return $this->render('admin/article/read.html.twig', [
            'article' => $listArticle]);
    }
    /**
     * @Route("/articleadmin/ajouter", name="createartadmin" ,methods={"GET","POST"})
     */

    public function createArticleAdmin (Request $req){
        $article=new Article();
        $form=$this->createForm(ArticleType::class,$article);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('img')->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);
            $article->setImg($fileName);
            $article->setImg($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('readartadmin');
        }
        return $this->render('admin/article/create.html.twig', [
            'form' => $form->createView()]);

    }
    /**
     * @Route("/articleadmin/update/{id}", name="updateartadmin")
     */

    public function updateArticleAdmin(Request $req,$id){
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $article=$repo->find($id);
        $form=$this->createForm(ArticleType::class,$article);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('img')->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $article->setImg($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('readartadmin');
        }
        return $this->render('/admin/article/update.html.twig', [
            'form' => $form->createView()]);
    }
    /**
     * @Route("/articleadmin/delete/{id}", name="deleteartadmin")
     */

    public function deleteArticleAdmin ($id){
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->find($id);
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('readartadmin');
}


}
