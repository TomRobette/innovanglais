<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Abonnement;
use App\Form\AjoutAbonnementType;
use Symfony\Component\HttpFoundation\Request;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/ajoutAbonnement", name="ajoutAbonnement")
     */
    public function ajoutAbonnement(Request $request)
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AjoutAbonnementType::class,$abonnement);
        
        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
              $em = $this->getDoctrine()->getManager();              
              $em->persist($abonnement);              
              $em->flush();        
            $this->addFlash('notice','Abonnement ajouté'); 
           
            } 
            return $this->redirectToRoute('ajoutAbonnement');
          }

        return $this->render('abonnement/ajoutAbonnement.html.twig', [
            'form'=>$form->createView()
        ]);
    }

            /**
         * @Route("/listeAbonnement", name="listeAbonnement")
         */
        public function listeAbonnement(Request $request)
        {
            $em = $this->getDoctrine();
            $repoAbonnement = $em->getRepository(Abonnement::class);
            $abonnement = $repoAbonnement->findBy(array(),array('id'=>'ASC'));

            
            return $this->render('abonnement/listeAbonnement.html.twig', [
                'abonnement'=>$abonnement
            ]);
        }
}
