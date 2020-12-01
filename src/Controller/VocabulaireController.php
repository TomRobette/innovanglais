<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutVocabulaireType;
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

                $this->addFlash('notice','Vocabulaire inséré');
                return $this->redirectToRoute('static');        
            }          
        }
        return $this->render('vocabulaire/ajoutVoc.html.twig', [
            'form'=>$form->createView() 
        ]);
    }

    /**
     * @Route("/liste_vocabulaires", name="liste_vocabulaires")
     */
    public function liste_vocabulaires(Request $request)
    {
        $em = $this->getDoctrine();
        $repoVoc = $em->getRepository(Vocabulaire::class);

        if($request->get('supp')!=null){
            $voc = $repoVoc->find($request->get('supp'));
            if($voc!=null){
                $em->getManager()->remove($voc);
                $em->getManager()->flush();
            }
            $this->redirectToRoute('liste_vocabulaires');
        }

        $vocs = $repoVoc->findAll();
        return $this->render('vocabulaire/liste_vocs.html.twig', [            
            'vocs'=>$vocs
        ]);
    }
}
