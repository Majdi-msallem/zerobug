<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="readarticle")
     */
    public function readArticle(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $listArticle =$repo->findAll();

        return $this->render('article/Read.html.twig', [
            'article' => $listArticle]);
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
        return $this->redirectToRoute('read');
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
     * @Route("/articleadmin/ajouter", name="createartadmin")
     */

    public function createArticleAdmin (Request $req){
        $article=new Article();
        $form=$this->createForm(ArticleType::class,$article);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
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
