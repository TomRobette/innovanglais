<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutVocabulaireType;
use App\Form\ModifVocabulaireType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Vocabulaire;

class VocabulaireController extends AbstractController
{
    /**
     * @Route("/ajoutVocabulaire", name="ajoutVocabulaire")
     */
    public function ajoutVocabulaire(Request $request)
    {
        $vocabulaire = new Vocabulaire();
        $form = $this->createForm(AjoutVocabulaireType::class,$vocabulaire);
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($vocabulaire);
                $em->flush();

                $this->addFlash('notice','Vocabulaire Ajouté');
                return $this->redirectToRoute('static');        
            }          
        }
        return $this->render('vocabulaire/ajoutVoc.html.twig', [
            'form'=>$form->createView() 
        ]);
    }

    /**
     * @Route("/listeVocabulaire", name="listeVocabulaire")
     */
    public function listeVocabulaires(Request $request)
    {
        $em = $this->getDoctrine();
        $repoVoc = $em->getRepository(Vocabulaire::class);

        if($request->get('supp')!=null){
            $voc = $repoVoc->find($request->get('supp'));
            if($voc!=null){
                $em->getManager()->remove($voc);
                $em->getManager()->flush();
            }
            $this->redirectToRoute('listeVocabulaire');
        }

        $vocs = $repoVoc->findBy(array(), array('id'=>'ASC'));
        return $this->render('vocabulaire/listeVocabulaire.html.twig', [            
            'vocs'=>$vocs
        ]);
    }

    /**
     * @Route("/modifVocabulaire/{id}", name="modifVocabulaire", requirements={"id"="\d+"})
     */
    public function modifVocabulaire(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoVocabulaire = $em->getRepository(Vocabulaire::class);
        $vocs = $repoVocabulaire->find($id);

        if($vocs==null){
            $this->addFlash('notice','Cette page n\'existe pas');
            return $this->redirectToRoute('listeVocabulaire');   
        }

        $form = $this->createForm(ModifVocabulaireType::class,$vocs);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($vocs);
                $em->flush();
                $this->addFlash('notice','Vocabulaire modifié');
                return $this->redirectToRoute('listeVocabulaire');        
            }          
        } 

        return $this->render('vocabulaire/modifVocabulaire.html.twig', [            
            'form'=>$form->createView()        
        ]);
    }
}
