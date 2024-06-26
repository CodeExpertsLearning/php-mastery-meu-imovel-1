<?php

namespace Code\Framework\Database\Repository;

use Code\Framework\Database\Model\Model;

interface RepositoryInterface
{
    public function getModel(): Model;
}
