<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\AjoutUserType;
use App\Form\ModifUserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/ajout_user", name="ajout_user")
     */
    public function ajout_user(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $form = $this->createForm(AjoutUserType::class, $user);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $mdpConf = $form->get('confirmation')->getData();
                $mdp = $user->getPassword();
                if($mdp==$mdpConf){
                    $user->setRoles(array('ROLE_USER'));
                    $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword())); 
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                }
               
               
               $this->addFlash('notice','Utilisateur ajouté');
               return $this->redirectToRoute('ajout_user');
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

            if($request->get('supp')!=null){
                $user = $repoUser->find($request->get('supp'));
                if($user!=null){
                    $em->getManager()->remove($user);
                    $em->getManager()->flush();
                }
                $this->redirectToRoute('liste_user');
            }
    
            $user = $repoUser->findBy(array(), array('id'=>'ASC'));
            
            
            return $this->render('user/liste_user.html.twig', [
                'user'=>$user
            ]);
        }

                    /**
     * @Route("/modifUser/{id}", name="modifUser", requirements={"id"="\d+"})
     */
    public function modifUser(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoUser = $em->getRepository(User::class);
        $user = $repoUser->find($id);

        if($user==null){
            $this->addFlash('notice','Cette page n\'existe pas');
            return $this->redirectToRoute('liste_user');   
        }

        $form = $this->createForm(ModifUserType::class,$user);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice','Utilisateur modifié');
                return $this->redirectToRoute('liste_user');        
            }          
        } 

        return $this->render('user/modifUser.html.twig', [            
            'form'=>$form->createView()        
        ]);
    }
}
