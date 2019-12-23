<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
     /**
     *@Route("/add", name="category_add", methods="GET|POST")
     * @IsGranted("ROLE_SUBSCRIBER")
     */

    public function add(Request $request, CategoryRepository $categoryRepository)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category,['method' => Request::METHOD_GET]);
        $form->handleRequest($request);

        $categories = $categoryRepository->findAll();

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_add');

        }

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }
}
