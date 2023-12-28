<?php

namespace App\State;

use App\Entity\StateableIntreface;
use App\Entity\Ticket;
use App\Enum\Status;

readonly class Lock implements StateInterface
{
    public function __construct(private Ticket $context)
    {
    }

    public function state(): Status
    {
        return Status::LOCK;
    }

    public function getContext(): StateableIntreface
    {
        return $this->context;
    }

    public function handle(): void
    {
        $this->context->setStatus(Status::LOCK->value);
    }

    public function writeHistory(): bool
    {
        return true;
    }

    public function notify(): bool
    {
        return false;
    }
}
