<?php

declare(strict_types=1);

namespace SwResearch\UserInterface\Controller;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\CreateTodoCommand;
use SwResearch\Application\Command\RemoveTodoCommand;
use SwResearch\Application\Command\UpdateTodoNameCommand;
use SwResearch\Application\Command\UpdateTodoPositionCommand;
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
        MessageBusInterface $messageBus,
        TodoQueryInterface $todoQuery
    ): Response {
        $payload = json_decode($request->getContent(), true);
        $todoQuery->getLastPosition();

        $messageBus
            ->dispatch(
                new CreateTodoCommand(
                    Uuid::uuid4()->toString(),
                    $payload['name'],
                    $todoQuery->getLastPosition() + 1
                )
            );


        return $this->json(
            [],
            200,
            ["Content-Type" => "application/json"]
        );
    }

    #[Route(path: "/api/todo/position", name: "update_todo_position", methods: ["PUT"])]
    function updateTodoPosition(
        Request $request,
        MessageBusInterface $messageBus,
        TodoQueryInterface $todoQuery
    ): Response {
        $payload = json_decode($request->getContent(), true);

        $firstTodo = $todoQuery->getById($payload['id']);
        $secondTodo = $todoQuery->getByPosition($payload['position']);

        $messageBus
            ->dispatch(
                new UpdateTodoPositionCommand(
                    $secondTodo->id(),
                    $firstTodo->position(),
                )
            );

        $messageBus
            ->dispatch(
                new UpdateTodoPositionCommand(
                    $firstTodo->id(),
                    $secondTodo->position(),
                )
            );


        return $this->json(
            [],
            200,
            ["Content-Type" => "application/json"]
        );
    }

    #[Route(path: "/api/todo/name", name: "update_todo_name", methods: ["PUT"])]
    function updateTodoName(
        Request $request,
        MessageBusInterface $messageBus,
    ): Response {
        $payload = json_decode($request->getContent(), true);

        $messageBus
            ->dispatch(
                new UpdateTodoNameCommand(
                    $payload['id'],
                    $payload['name'],
                )
            );


        return $this->json(
            [],
            200,
            ["Content-Type" => "application/json"]
        );
    }

    #[Route(path: "/api/todo/{id}", name: "remove_todo", methods: ["DELETE"])]
    function removeTodo(
        string $id,
        MessageBusInterface $messageBus,
    ): Response {
        $messageBus
            ->dispatch(
                new RemoveTodoCommand(
                    $id
                )
            );


        return $this->json(
            [],
            200,
            ["Content-Type" => "application/json"]
        );
    }
}
