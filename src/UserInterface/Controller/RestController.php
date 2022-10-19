<?php

declare(strict_types=1);

namespace SwResearch\UserInterface\Controller;

use SwResearch\Domain\TodoInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    #[Route(path: "/api/todos", name: "get_all_todos", methods: ["GET"])]
    function getAllTodos(
        TodoInterface $todos
    ): Response
    {
        return $this->json(
            $todos->getAll(),
            200,
            ["Content-Type" => "application/json"]
        );
    }
}
