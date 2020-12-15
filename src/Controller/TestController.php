<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Test;
use App\Form\AjoutTestType;
use App\Form\ModifTestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EntityType;


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

            if($request->get('supp')!=null){
                $test = $repoTest->find($request->get('supp'));
                if($test!=null){
                    $em->getManager()->remove($test);
                    $em->getManager()->flush();
                }
                $this->redirectToRoute('listeTest');
            }
    
            $test = $repoTest->findBy(array(), array('id'=>'ASC'));
            
            return $this->render('test/listeTest.html.twig', [
                'test'=>$test
            ]);
        }

                    /**
     * @Route("/modiTest/{id}", name="modifTest", requirements={"id"="\d+"})
     */
    public function modifTest(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoTest = $em->getRepository(Test::class);
        $test = $repoTest->find($id);

        if($test==null){
            $this->addFlash('notice','Cette page n\'existe pas');
            return $this->redirectToRoute('listeTest');   
        }

        $form = $this->createForm(ModifTestType::class,$test);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($test);
                $em->flush();
                $this->addFlash('notice','Test modifié');
                return $this->redirectToRoute('listeTest');        
            }          
        } 

        return $this->render('test/modifTest.html.twig', [            
            'form'=>$form->createView()        
        ]);
    }
}
