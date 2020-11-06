<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="cours")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $listCours = $em->getRepository(Cours::class)->findAll();

        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($cours);
            $em->flush();

            $this->addFlash('success', 'Cours ajouté');
        }


        return $this->render('cours/index.html.twig', [
            'cours' => $listCours,
            'ajoutCours' => $form->createView()
        ]);
    }

    /**
     * @Route("/cours/{id}", name="showCours")
     */

    public function showCours(Cours $cours = null){
        if($cours == null){
            $this->addFlash('error', "Cours introuvable");
            $this->redirectToRoute('cours');
        }

        return $this->render('cours/showCours.html.twig', [
            'cours' => $cours
        ]);

    }
}
