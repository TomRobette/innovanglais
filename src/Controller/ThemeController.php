<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Theme;
use App\Form\AjoutThemeType;
use Symfony\Component\HttpFoundation\Request;

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
}
