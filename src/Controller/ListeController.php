<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Liste;
use App\Form\AjoutListeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ListeController extends AbstractController
{
    /**
     * @Route("/ajoutListe", name="ajoutListe")
     */
    public function ajoutListe(Request $request)
    {
        $liste = new Liste();
        $form = $this->createForm(AjoutListeType::class,$liste);
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($liste);
                $em->flush();

                $this->addFlash('notice','Liste insérée');
                return $this->redirectToRoute('static');        
            }          
        }
        return $this->render('liste/ajoutListe.html.twig', [
            'form'=>$form->createView() 
        ]);
    }
}
