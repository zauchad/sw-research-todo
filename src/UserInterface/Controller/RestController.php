<?php

declare(strict_types=1);

namespace SwResearch\UserInterface\Controller;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\CreateTodoCommand;
use SwResearch\Application\Query\TodoQueryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    #[Route(path: "/api/todos", name: "get_all_todo", methods: ["GET"])]
    function getAllTodos(
        TodoQueryInterface $todoQuery
    ): Response
    {
        return $this->json(
            $todoQuery->getAll(),
            200,
            ["Content-Type" => "application/json"]
        );
    }

    #[Route(path: "/api/todo", name: "create_todo", methods: ["POST"])]
    function createTodo(
        Request $request,
        MessageBusInterface $messageBus
    ): Response {
        $payload = json_decode($request->getContent(), true);

        $messageBus
            ->dispatch(
                new CreateTodoCommand(
                    Uuid::uuid4()->toString(),
                    $payload['name'],
                    $payload['position']
                )
            );


        return $this->json(
            [],
            200,
            ["Content-Type" => "application/json"]
        );
    }
}
