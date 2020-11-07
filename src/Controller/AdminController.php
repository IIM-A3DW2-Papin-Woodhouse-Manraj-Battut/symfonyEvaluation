<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Cours;
use App\Form\CategorieType;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $cours = $em->getRepository(Cours::class)->findAll();
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'cours' => $cours,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/ajouterCours", name="ajouterCours")
     */

    public function ajouterCours(Request $request){
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();

            $this->addFlash('success', 'Categorie ajoutée');
        }

        return $this->render("/admin/ajouterCours.html.twig", [
            "ajoutCours" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modifierCours/{id}", name="modifierCours")
     */

    public function modifierCours(Cours $cours = null, Request $request){
        if($cours == null){
            $this->addFlash('error', "Cours introuvable");
            $this->redirectToRoute('admin');
        }

        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();

            $this->addFlash('success', 'Cours modifié');
        }

        return $this->render('admin/modifierCours.html.twig', [
            'cours' => $cours,
            'modifierCours' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimerCours/{id}", name="supprimerCours")
     */

    public function supprimerCours(Cours $cours = null){
        if($cours == null){
            $this->addFlash('error', "Cours introuvable");
            $this->redirectToRoute('admin');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($cours);
        $em->flush();

        $this->addFlash('success', "Cours supprimé");
        return $this->redirectToRoute("admin");
    }

    /**
     * @Route("/admin/ajouterCategorie", name="ajouterCategorie")
     */

    public function ajouterCategorie(Request $request){
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Categorie ajoutée');
        }

        return $this->render("/admin/ajouterCategorie.html.twig", [
            "ajoutCategorie" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modifierCategorie/{id}", name="modifierCategorie")
     */

    public function modifierCategorie(Categorie $categorie = null, Request $request){
        if($categorie == null){
            $this->addFlash('error', "Catégorie introuvable");
            $this->redirectToRoute('admin');
        }

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Categorie modifiée');
        }

        return $this->render('admin/modifierCategorie.html.twig', [
            'categorie' => $categorie,
            'modifierCategorie' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimerCategorie/{id}", name="supprimerCategorie")
     */

    public function supprimerCategorie(Categorie $categorie){
        if ($categorie == null){
            $this->addFlash('error', "Categorie introuvable");
            return $this->redirectToRoute("admin");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();


        $this->addFlash('success', "Catégorie supprimée");
        return $this->redirectToRoute("admin");
    }


}
