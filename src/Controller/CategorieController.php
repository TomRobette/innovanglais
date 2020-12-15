<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Form\AjoutCategorieType;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    /**
     * @Route("/ajoutCategorie", name="ajoutCategorie")
     */
    public function ajoutCategorie(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm(AjoutCategorieType::class,$categorie);



        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
              $em = $this->getDoctrine()->getManager();              
              $em->persist($categorie);              
              $em->flush();        
            $this->addFlash('notice','>Catégorie ajouté'); 
           
            } 
            return $this->redirectToRoute('ajoutCategorie');
          }

        return $this->render('categorie/ajoutCategorie.html.twig', [
            'form'=>$form->createView()
        ]);
    }

          /**
         * @Route("/listeCategorie", name="listeCategorie")
         */
        public function liste_categorie(Request $request)
        {
            $em = $this->getDoctrine();
            $repoCategorie = $em->getRepository(Categorie::class);
            $categorie = $repoCategorie->findBy(array(),array('id'=>'ASC'));

            
            return $this->render('categorie/listeCategorie.html.twig', [
                'categorie'=>$categorie
            ]);
        }
}
