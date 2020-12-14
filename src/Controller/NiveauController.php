<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Niveau;
use App\Form\AjoutNiveauType;
use Symfony\Component\HttpFoundation\Request;

class NiveauController extends AbstractController
{
    /**
     * @Route("/ajoutNiveau", name="ajoutNiveau")
     */
    public function ajoutNiveau(Request $request)
    {
        $niveau = new Niveau();
        $form = $this->createForm(AjoutNiveauType::class,$langue);



        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
              $em = $this->getDoctrine()->getManager();              
              $em->persist($niveau);              
              $em->flush();        
            $this->addFlash('notice','>Catégorie ajouté'); 
           
            } 
            return $this->redirectToRoute('ajoutNiveau');
          }

        return $this->render('niveau/ajoutNiveau.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
