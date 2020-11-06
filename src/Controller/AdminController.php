<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Cours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


}
