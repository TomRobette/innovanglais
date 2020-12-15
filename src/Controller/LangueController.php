<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Langue;
use App\Form\AjoutLangueType;
use Symfony\Component\HttpFoundation\Request;

class LangueController extends AbstractController
{
    /**
     * @Route("/ajoutLangue", name="ajoutLangue")
     */
    public function ajoutLangue(Request $request)
    {
        $langue = new Langue();
        $form = $this->createForm(AjoutLangueType::class,$langue);



        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
              $em = $this->getDoctrine()->getManager();              
              $em->persist($langue);              
              $em->flush();        
            $this->addFlash('notice','Langue ajouté'); 
           
            } 
            return $this->redirectToRoute('ajoutLangue');
          }

        return $this->render('langue/ajoutLangue.html.twig', [
            'form'=>$form->createView()
        ]);
    }

           /**
         * @Route("/listeLangue", name="listeLangue")
         */
        public function listeLangue(Request $request)
        {
            $em = $this->getDoctrine();
            $repoLangue = $em->getRepository(Langue::class);
            $langue = $repoLangue->findBy(array(),array('id'=>'ASC'));

            
            return $this->render('langue/listeLangue.html.twig', [
                'langue'=>$langue
            ]);
        }
}
