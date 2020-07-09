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
        $user = new User();
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
    
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

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
        $allUsers = $users->findAll();
        $allPics = $pics->findAll();

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

        $user = $repo->find($id);
        $allUsers = $repo->findAll();

        if(count($allUsers) === 1) {
            $this->addFlash('error', 'Vous ne pouvez supprimer le dernier administrateur.');

            return $this->redirectToRoute('admin_dashboard');
        }
        

        $manager->remove($user);
        $manager->flush();

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

        $pic = $repo->find($id);
    
        $pic->setValid(1);

        $manager->persist($pic);
        $manager->flush();

        $this->addFlash('success', 'La photo a bien été activé !');

        return $this->redirectToRoute('admin_dashboard');
    }
}
