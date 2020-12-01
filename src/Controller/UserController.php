<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Abonnement;
use App\Form\AjoutUserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Repository\AbonnementRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/ajout_user", name="ajout_user")
     */
    public function ajout_user(Request $request)
    {
        $user = new User();
        $abonnement = new Abonnement();

        $form = $this->createForm(AjoutUserType::class, $user);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $abonnement->setAbonnement("1");
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
               
               $this->addFlash('notice','Utilisateur ajouté');
               return $this->redirectToRoute('Ajout_user');
            }
        }
        return $this->render('user/ajout_user.html.twig', [
            'form'=>$form->createView()
        ]);
    }

                /**
         * @Route("/liste_user", name="liste_user")
         */
        public function liste_user(Request $request)
        {
            $em = $this->getDoctrine();
            $repoUser = $em->getRepository(User::class);
            $user = $repoUser->findAll();
            return $this->render('user/liste_user.html.twig', [
                'user'=>$user
            ]);
        }
}
