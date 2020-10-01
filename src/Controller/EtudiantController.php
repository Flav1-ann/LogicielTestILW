<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Etudiant;
use App\Entity\Cours;
use App\Repository\EtudiantRepository;
use App\Repository\CoursRepository;
use App\Form\CreateEtudiantFormType;
use App\Form\CreateCourFormType;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/", name="etudiant")
     */
    public function index(EtudiantRepository $etudiantRepo,CoursRepository $coursRepo)
    {
        $etudiants = $etudiantRepo->findAll();
        $cours = $coursRepo->findAll();
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
            'etudiants' => $etudiants,
            'cours' => $cours
        ]);
    }

    /**
     * @Route("/createtudiant", name="create")
     */
    public function createudiant(EntityManagerInterface $manager, Request $request)
    {

        $etudiant = new Etudiant();
        $etudiantForm = $this->createForm(CreateEtudiantFormType::class, $etudiant);
        $etudiantForm->handleRequest($request);
        if ($etudiantForm->isSubmitted() && $etudiantForm->isValid()){
            $manager->persist($etudiant);
            $manager->flush();
            return $this->redirectToRoute('etudiant');
        }

        return $this->render('etudiant/create.html.twig', [
            'controller_name' => 'EtudiantController',
            'etudiantForm' => $etudiantForm->createView(),
        ]);
    }


    /**
     * @Route("/consulterEtudiant/{id}", name="consulterEtudiant")
     */
    public function consulterEtudiant(EntityManagerInterface $manager, Request $request, Etudiant $etudiant )
    {
      
        $etudiantForm = $this->createForm(CreateEtudiantFormType::class, $etudiant);
        $etudiantForm->handleRequest($request);
        if ($etudiantForm->isSubmitted() && $etudiantForm->isValid()){
            $manager->persist($etudiant);
            $manager->flush();
            return $this->redirectToRoute('etudiant');
        }

       
       
        return $this->render('etudiant/edit.html.twig', [
            'controller_name' => 'EtudiantController',
            'etudiantForm' => $etudiantForm->createView(),
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * @Route("/supprimerEtudiant/{id}", name="supprimerEtudiant")
     */
    public function supprimerEtudiant(Etudiant $etudiant, EtudiantRepository $etudiantRepo)
    {
        $etudiantRepo->deleteOne($etudiant->getId());
        return $this->redirectToRoute('etudiant');
    }


}
