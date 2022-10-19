<?php

declare(strict_types=1);

namespace SwResearch\Application\Query;

use SwResearch\Application\Query\Model\Todo;

interface TodoQueryInterface
{
    /**
     * @return Todo[]
     */
    public function getAll() : array;
}
