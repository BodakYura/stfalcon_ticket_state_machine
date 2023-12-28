<?php

namespace App\Entity;

use App\State\StateInterface;

interface StateableIntreface
{
    public function getId(): int;

    public function getState(): StateInterface;
}
