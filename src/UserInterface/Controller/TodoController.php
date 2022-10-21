<?php

declare(strict_types=1);

namespace SwResearch\UserInterface\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route("/", name: "list_todos", methods: ["GET"])]
    public function listHtml() : Response
    {
        return $this->render("list.html.twig");
    }
}
