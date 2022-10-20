<?php

declare(strict_types=1);

namespace SwResearch\Infrastructure\CommandBus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Throwable;

class FailureCatcherMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack) : Envelope
    {
        try {
            $returnedEnvelope = $stack->next()->handle($envelope, $stack);
        } catch (HandlerFailedException $exception) {
            if ($exception->getPrevious() instanceof Throwable) {
                throw $exception->getPrevious();
            }
            throw $exception;
        }

        return $returnedEnvelope;
    }
}
