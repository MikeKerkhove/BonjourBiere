<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\PicturesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin/new", name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // Création d'un nouvel administrateur
        $user = new User();
        $manager = $this->getDoctrine()->getManager();

        // Création du formulaire
        $form = $this->createForm(RegistrationType::class, $user);

        // Récupération des données du formulaire
        $form->handleRequest($request);

        // Vérification des données, Encodage du mot de passe
        if($form->isSubmitted() && $form->isValid()) {
    
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            
            // Ajout d'un message de succes à la création
            $this->addFlash('success', 'Votre utilisateur a bien été créé !');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {}

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function admin(UserRepository $users, PicturesRepository $pics, Request $request, PaginatorInterface $paginator) {

        // Récupération des tous les administrateurs ainsi que des photos
        $allUsers = $users->findAll();
        $allPics = $pics->findAll();

        // Création de la pagination des photos a partir de 10 éléments
        $pictures = $paginator->paginate(
            $allPics,
            $request->query->getInt('page', 1),
            10 
        );

        return $this->render('security/admin.html.twig', [
            'users' => $allUsers,
            'pictures' => $pictures
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="security_admin_delete")
     */
    public function adminDelete($id)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $manager = $this->getDoctrine()->getManager();

        // Récuperation du compte administrateur a supprimer
        $user = $repo->find($id);
        $allUsers = $repo->findAll();

        // Vérification empechant de supprimer un administrateur si c'est le dernier.
        if(count($allUsers) === 1) {
            $this->addFlash('error', 'Vous ne pouvez supprimer le dernier administrateur.');

            return $this->redirectToRoute('admin_dashboard');
        }
        
        // Suppression du compte administrateur en question
        $manager->remove($user);
        $manager->flush();

        // Ajout d'un message de succes
        $this->addFlash('success', 'L\'utilisateur a bien été supprimé !');

        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/picture/update/{id}", name="security_picture_update")
     */
    public function pictureUpdate($id)
    {
        $repo = $this->getDoctrine()->getRepository(Pictures::class);
        $manager = $this->getDoctrine()->getManager();

        // Récupération de la photo dont l'id correspond
        $pic = $repo->find($id);
    
        // Changement de la valeur 'Valid'
        $pic->setValid(1);

        // Modification de la photo en BDD
        $manager->persist($pic);
        $manager->flush();

        // Ajout d'un message de succes
        $this->addFlash('success', 'La photo a bien été activé !');

        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/picture/delete/{id}", name="security_picture_delete")
     */
    public function pictureDelete($id)
    {
        $repo = $this->getDoctrine()->getRepository(Pictures::class);
        $manager = $this->getDoctrine()->getManager();

        // Récupération de la photo dont l'id correspond
        $pic = $repo->find($id);

        // Suppression de la photo en BDD
        $manager->remove($pic);
        $manager->flush();

        // Ajout d'un message de succes
        $this->addFlash('success', 'La photo a bien été supprimé !');

        return $this->redirectToRoute('admin_dashboard');
    } 
}
