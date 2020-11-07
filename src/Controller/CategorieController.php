<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie")
     */
    public function index(Request $request) :Response
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="showCategorie")
     */

    public function showCategorie(Categorie $categorie = null){
        if($categorie == null){
            $this->addFlash('error', "Catégorie introuvable");
            $this->redirectToRoute('categorie');
        }

        $cours = $categorie->getCours();

        return $this->render('categorie/showCategorie.html.twig', [
            'categorie' => $categorie,
            'cours' => $cours
        ]);
    }

}
