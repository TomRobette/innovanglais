<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Form\AjoutEntrepriseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/ajoutEntreprise", name="ajoutEntreprise")
     */
    public function ajoutEntreprise(Request $request)
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(AjoutEntrepriseType::class,$entreprise);
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entreprise);
                $em->flush();

                $this->addFlash('notice','Entreprise ajouté');
                return $this->redirectToRoute('static');        
            }          
        }
        return $this->render('entreprise/ajoutEntreprise.html.twig', [
            'form'=>$form->createView() 
        ]);
    }

           /**
         * @Route("/listeEntreprise", name="listeEntreprise")
         */
        public function listeEntreprise(Request $request)
        {
            $em = $this->getDoctrine();
            $repoEntreprise = $em->getRepository(Entreprise::class);
            $entreprise = $repoEntreprise->findBy(array(),array('id'=>'ASC'));

            
            return $this->render('entreprise/listeEntreprise.html.twig', [
                'entreprise'=>$entreprise
            ]);
        }
}
