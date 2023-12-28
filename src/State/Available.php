<?php

namespace App\State;

use App\Entity\StateableIntreface;
use App\Entity\Ticket;
use App\Enum\Status;

readonly class Available implements StateInterface
{
    public function __construct(private Ticket $context)
    {
    }

    public function state(): Status
    {
        return Status::AVAILABLE;
    }

    public function getContext(): StateableIntreface
    {
        return $this->context;
    }

    public function handle(): void
    {
        $this->context->setStatus(Status::AVAILABLE->value);
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
