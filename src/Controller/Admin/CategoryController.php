<?php

namespace App\Controller\Admin;

use App\Entity\Category;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Candy;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/category', 'admin_category_')]
class CategoryController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/', 'index')]
    public function index(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();
        return $this->render('Admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/create', 'create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $object = new Category;
        $form = $this->createForm(CategoryType::class, $object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $object->setCreateAt(new DateTimeImmutable());
            $em->persist($object);
            $em->flush();

            $this->addFlash('sucess','Une nouvelle catégorie à été créer');
            return $this->redirectToRoute('admin_category_index');
        }

        // $object->setName('Sucettes')
        //     ->setDescription('bonbon à sucer avec de différentes saveurs')
        //     ->setCreateAt(new DateTimeImmutable())
        //     ->setUpdateAt(new DateTimeImmutable());

        // $em->persist($object);
        // $em->flush();

        return $this->render('Admin/category/create.html.twig', [
            'formulaire' => $form
        ]);
    }

    #[Route('/update/{id}', 'update')]
    public function update(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setUpdateAt(new DateTimeImmutable());
            $em->flush();

            $this->addFlash('sucess','La catégorie a été modifier');
            return $this->redirectToRoute('admin_category_index');
        }
        // $object = $repository->find($id);
        // $object->setName('Guimauve');

        // $em->flush();
        return $this->render('Admin/category/update.html.twig', [
            'formulaire' => $form
        ]);
    }

    #[Route('/delete/{id}', 'delete')]
    public function delete($id, EntityManagerInterface $em, Category $category): Response
    {
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('admin_category_index');
    }
}