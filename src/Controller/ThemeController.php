<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Theme;
use App\Form\AjoutThemeType;
use App\Form\ModifThemeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EntityType;


class ThemeController extends AbstractController
{
    /**
     * @Route("/ajoutTheme", name="ajoutTheme")
     */
    public function ajoutTheme(Request $request)
    {
        $theme = new Theme();
        $form = $this->createForm(AjoutThemeType::class,$theme);
        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
              $em = $this->getDoctrine()->getManager();              
              $em->persist($theme);              
              $em->flush();        
            $this->addFlash('notice','Theme ajouté'); 
           
            } 
            return $this->redirectToRoute('ajoutTheme');
          }

        return $this->render('theme/ajoutTheme.html.twig', [
            'form'=>$form->createView()
        ]);
    }

            /**
         * @Route("/listeTheme", name="listeTheme")
         */
        public function listeTheme(Request $request)
        {
            $em = $this->getDoctrine();
            $repoTheme = $em->getRepository(Theme::class);

            if($request->get('supp')!=null){
                $theme = $repoTheme->find($request->get('supp'));
                if($theme!=null){
                    $em->getManager()->remove($theme);
                    $em->getManager()->flush();
                }
                $this->redirectToRoute('listeTheme');
            }
    
            $theme = $repoTheme->findBy(array(), array('id'=>'ASC'));   
            return $this->render('theme/listeTheme.html.twig', [
                'theme'=>$theme
            ]);
        }

            /**
     * @Route("/modiTheme/{id}", name="modifTheme", requirements={"id"="\d+"})
     */
    public function modifTheme(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
        $theme = $repoTheme->find($id);

        if($theme==null){
            $this->addFlash('notice','Cette page n\'existe pas');
            return $this->redirectToRoute('listeTheme');   
        }

        $form = $this->createForm(ModifThemeType::class,$theme);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();
                $this->addFlash('notice','Thème modifié');
                return $this->redirectToRoute('listeTheme');        
            }          
        } 

        return $this->render('theme/modifTheme.html.twig', [            
            'form'=>$form->createView()        
        ]);
    }
}