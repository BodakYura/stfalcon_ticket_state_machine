<?php

namespace App\State;

use App\Entity\StateableIntreface;
use App\Entity\Ticket;
use App\Enum\Status;

interface StateInterface
{
    public function state(): Status;

    public function writeHistory(): bool;

    public function getContext(): StateableIntreface;

   public function handle(): void;

    public function notify(): bool;

}
