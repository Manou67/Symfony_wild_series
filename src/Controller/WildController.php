<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wild", name="wild_")
 */

class WildController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index() :Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @param string $slug The slugger
     * @Route("/wild/show/{slug}",
     *     requirements={"slug"="[a-z0-9-]+"},
     *     defaults={"slug"="Aucune série sélectionnée, veuillez choisir une série"},
     *     name="wild_show")
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug){
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table .');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }
        return $this->render('wild/show.html.twig',
            ['program' => $program,
                'slug' => $slug,
            ]);
    }

    /**
     * @param string $categoryName
     * @Route("/wild/category/{categoryName}",
     *     requirements={"category"="[a-z0-9-]+"},
     *     defaults={"category"="Aucune catégorie sélectionnée, veuillez choisir une catégorie"},
     *     name="show_category")
     * @return Response
     */
    public function showByCategory(string $categoryName) : Response
    {
        $category = $this ->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=>$categoryName]);
        $program =  $this ->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category'=>$category->getId()], ['id'=>'DESC'], 3);
        return $this->render('wild/category.html.twig',
            ['category' => $categoryName,
                'programs' => $program,
            ]);
    }
}