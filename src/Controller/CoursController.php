<?php

namespace App\Controller;

use App\Entity\Cours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CreateCourFormType;


class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="cours")
     */
    public function index()
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    /**
     * @Route("/CreateCour", name="CreateCour")
     */
    public function CreateCour(EntityManagerInterface $manager, Request $request)
    {
        $cour = new Cours();
        $coursform = $this->createForm(CreateCourFormType::class,$cour);
        $coursform->handleRequest($request);
        if ($coursform->isSubmitted() && $coursform->isValid()){
            $manager->persist($cour);
            $manager->flush();
            return $this->redirectToRoute('etudiant');
        }
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
            'coursForm' => $coursform->createView(),
        ]);
    }
}
