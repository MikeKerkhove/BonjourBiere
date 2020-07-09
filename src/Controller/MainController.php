<?php

namespace App\Controller;

use App\Entity\Pictures;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PicturesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(PicturesRepository $repo, Request $request, PaginatorInterface $paginator) {
        $data = $repo->findBy(['active' => 1, 'valid' => 1], ['date' => 'desc']);

        $pictures = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            1 
        );

        return $this->render('main/home.html.twig', [
            'pictures' => $pictures,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request) {
        $picture = new Pictures();

        $form = $this->createFormBuilder($picture)
                     ->add('name',TextType::class)
                     ->add('link', TextType::class)
                     ->add('proposedBy', TextType::class)
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $picture->setActive(0)
                    ->setDate(new \DateTime())
                    ->setValid(0);

            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($picture);
            $manager->flush();

            $this->addFlash('success', 'Votre demande a bien été prise en compte !');

            return $this->redirectToRoute('home');
        }

        return $this->render('main/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about() {
        return $this->render('main/about.html.twig');
    }

}
 