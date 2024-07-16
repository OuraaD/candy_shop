<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article_index')]

    public function index(): Response
    {
     return  $this->render('admin/article/index.html.twig');
    }
}