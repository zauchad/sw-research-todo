<?php

declare(strict_types=1);

namespace SwResearch\UserInterface\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function homeHtml() : Response
    {
        return $this->render('list.html.twig');
    }
}
