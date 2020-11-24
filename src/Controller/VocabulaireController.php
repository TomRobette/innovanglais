<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutFichierType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;

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
                return $this->redirectToRoute('ajout_fichier');        
            }          
        }
        return $this->render('vocabulaire/ajoutVoc.html.twig', [
            'form'=>$form->createView() 
        ]);
    }
}
