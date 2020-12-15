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
        $form = $this->createForm(AjoutNiveauType::class,$niveau);



        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
              $em = $this->getDoctrine()->getManager();              
              $em->persist($niveau);              
              $em->flush();        
            $this->addFlash('notice','Niveau ajouté'); 
           
            } 
            return $this->redirectToRoute('ajoutNiveau');
          }

        return $this->render('niveau/ajoutNiveau.html.twig', [
            'form'=>$form->createView()
        ]);
    }

           /**
         * @Route("/listeNiveau", name="listeNiveau")
         */
        public function listeNiveau(Request $request)
        {
            $em = $this->getDoctrine();
            $repoNiveau = $em->getRepository(Niveau::class);

            if($request->get('supp')!=null){
              $niveau = $repoNiveau->find($request->get('supp'));
              if($niveau!=null){
                  $em->getManager()->remove($niveau);
                  $em->getManager()->flush();
              }
              $this->redirectToRoute('listeNiveau');
          }
  
          $niveau = $repoNiveau->findBy(array(), array('id'=>'ASC'));
            
            return $this->render('niveau/listeNiveau.html.twig', [
                'niveau'=>$niveau
            ]);
        }
}
