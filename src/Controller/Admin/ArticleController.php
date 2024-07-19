<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use App\Entity\Candy;
use App\Form\CandyType;
use App\Repository\CandyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/article', 'admin_article_')]
class ArticleController extends AbstractController
{
    #[Route('/', 'index')]
    public function index(CandyRepository $repository): Response
    {
        $candy = $repository->findAll();
        return $this->render('Admin/article/index.html.twig', [
            "bonbons" => $candy
        ]);
    }

    #[Route('/create', 'create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $object = new Candy;
        // $object->setName('chamalow')
        //     ->setDescription('bonbon mou')
        //     ->setCreateAt(new DateTimeImmutable())
        //     ->setSlug('chamalow');
        $form = $this->createForm(CandyType::class, $object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $object->setCreateAt(new DateTimeImmutable());

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($object->getName());
            $object->setSlug(strtolower($slug));

            $em->persist($object);
            $em->flush();

            $this->addFlash('success', 'Ton bonbon a été créer');
            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('Admin/article/create.html.twig', [
            'formulaire_candy' => $form
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS])]
    public function update($id, Candy $candy, EntityManagerInterface $em, Request $request): Response
    {
        // Find() permet de récupérer un enregistrement de la base de donnée grâce à son id
        // $candy= $repository->find(1);

        // FindAll() permet de récuperer tous les enregistrements de la base données.
        // $candy=$repository->findAll();

        // FindBy() permet de récupérer tous les enregistrements de la base de données correspondent à des conditions sur les champs
        // $candy=$repository->findBy(['name'=>'chamalow']);

        // FindOneBy() permet de récuperer un enregistrement de la base de données correspondant à des conditions sur les champs
        // $candy=$repository->findOneBy([
        //     "slug"=>'chamalow',
        //     "name"=>'chamalow'
        // ]);

        // Récupérer l'objet qui contient ce qui est tapé dans l'url et ensuite comment mettre à jour la base de donnée
        // $candy = $repository->find($id);
        // $candy->setName('Tagada');
        $form = $this->createForm(CandyType::class, $candy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('sucess', 'La catégorie a été modifier');
            return $this->redirectToRoute('admin_article_index');
        }
        // dd($candy);

        return $this->render('Admin/article/update.html.twig', [
            'formulaire_candy' => $form
        ]);
    }


    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete($id, CandyRepository $repository, EntityManagerInterface $em, Candy $candy): Response
    {
        // Supprimer l'enregistrement  de la base de donnée qui à l'id passé en parametre 
        // $candy = $repository->find($id);
        $em->remove($candy);
        $em->flush();

        return $this->render('Admin/article/delete.html.twig');
    }
}
