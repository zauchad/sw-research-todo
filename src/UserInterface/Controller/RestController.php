<?php

declare(strict_types=1);

namespace SwResearch\UserInterface\Controller;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\CreateTodoCommand;
use SwResearch\Application\Command\RemoveTodoCommand;
use SwResearch\Application\Command\UpdateTodoNameCommand;
use SwResearch\Application\Command\UpdateTodoPositionCommand;
use SwResearch\Application\Query\TodoQueryInterface;
use SwResearch\Domain\Exception\DomainInvalidAssertionException;
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

        try {
            $messageBus
                ->dispatch(
                    new CreateTodoCommand(
                        Uuid::uuid4()->toString(),
                        $payload['name'],
                        $todoQuery->getLastPosition() + 1
                    )
                );
        } catch (DomainInvalidAssertionException $e) {
            return $this->json(
                [
                    'error' => $e->getMessage()
                ],
                400,
                ["Content-Type" => "application/json"]
            );
        }


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
    ): Response {
        $payload = json_decode($request->getContent(), true);

        try {
            $messageBus
                ->dispatch(
                    new UpdateTodoPositionCommand(
                        $payload['id'],
                        $payload['position'],
                    )
                );
        } catch (DomainInvalidAssertionException $e) {
            return $this->json(
                [
                    'error' => $e->getMessage()
                ],
                400,
                ["Content-Type" => "application/json"]
            );
        }

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

        try {
            $messageBus
                ->dispatch(
                    new UpdateTodoNameCommand(
                        $payload['id'],
                        $payload['name'],
                    )
                );
        } catch (DomainInvalidAssertionException $e) {
            return $this->json(
                [
                    'error' => $e->getMessage()
                ],
                400,
                ["Content-Type" => "application/json"]
            );
        }

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
        try {
            $messageBus
                ->dispatch(
                    new RemoveTodoCommand(
                        $id
                    )
                );
        } catch (DomainInvalidAssertionException $e) {
            return $this->json(
                [
                    'error' => $e->getMessage()
                ],
                400,
                ["Content-Type" => "application/json"]
            );
        }

        return $this->json(
            [],
            200,
            ["Content-Type" => "application/json"]
        );
    }
}
