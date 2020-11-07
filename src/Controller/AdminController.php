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
use Symfony\Contracts\Translation\TranslatorInterface;

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

    public function ajouterCours(Request $request, TranslatorInterface $translator){
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();


            $this->addFlash('success', $translator->trans('cours.ajoute'));
        }

        return $this->render("/admin/ajouterCours.html.twig", [
            "ajoutCours" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modifierCours/{id}", name="modifierCours")
     */

    public function modifierCours(Cours $cours = null, Request $request, TranslatorInterface $translator){
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

            $this->addFlash('success', $translator->trans('cours.modifié'));
        }

        return $this->render('admin/modifierCours.html.twig', [
            'cours' => $cours,
            'modifierCours' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimerCours/{id}", name="supprimerCours")
     */

    public function supprimerCours(Cours $cours = null, TranslatorInterface $translator){
        if($cours == null){
            $this->addFlash('error', "Cours introuvable");
            $this->redirectToRoute('admin');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($cours);
        $em->flush();

        $this->addFlash('success', $translator->trans('cours.suprimé'));
        return $this->redirectToRoute("admin");
    }

    /**
     * @Route("/admin/ajouterCategorie", name="ajouterCategorie")
     */

    public function ajouterCategorie(Request $request, TranslatorInterface $translator){
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', $translator->trans('categorie.ajoutee'));
        }

        return $this->render("/admin/ajouterCategorie.html.twig", [
            "ajoutCategorie" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modifierCategorie/{id}", name="modifierCategorie")
     */

    public function modifierCategorie(Categorie $categorie = null, Request $request, TranslatorInterface $translator){
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

            $this->addFlash('success', $translator->trans('categorie.modifiée'));
        }

        return $this->render('admin/modifierCategorie.html.twig', [
            'categorie' => $categorie,
            'modifierCategorie' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimerCategorie/{id}", name="supprimerCategorie")
     */

    public function supprimerCategorie(Categorie $categorie, TranslatorInterface $translator){
        if ($categorie == null){
            $this->addFlash('error', "Categorie introuvable");
            return $this->redirectToRoute("admin");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();


        $this->addFlash('success', $translator->trans('categorie.supprimée'));
        return $this->redirectToRoute("admin");
    }


}
