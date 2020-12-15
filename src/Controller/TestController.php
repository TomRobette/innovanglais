<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Test;
use App\Form\AjoutTestType;
use Symfony\Component\HttpFoundation\Request;

class TestController extends AbstractController
{
    /**
     * @Route("/ajoutTest", name="ajoutTest")
     */
    public function ajoutTest(Request $request)
    {
        $test = new Test();
        $form = $this->createForm(AjoutTestType::class, $test);
        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
              $em = $this->getDoctrine()->getManager();              
              $em->persist($test);              
              $em->flush();        
            $this->addFlash('notice','Test ajouté'); 
           
            } 
            return $this->redirectToRoute('ajoutTest');
          }

        return $this->render('test/ajoutTest.html.twig', [
            'form'=>$form->createView()
        ]);
    }

            /**
         * @Route("/listeTest", name="listeTest")
         */
        public function listeTest(Request $request)
        {
            $em = $this->getDoctrine();
            $repoTest = $em->getRepository(Test::class);
            $test = $repoTest->findBy(array(),array('id'=>'ASC'));

            
            return $this->render('test/listeTest.html.twig', [
                'test'=>$test
            ]);
        }
}
