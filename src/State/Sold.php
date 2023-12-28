<?php

namespace App\State;

use App\Entity\StateableIntreface;
use App\Entity\Ticket;
use App\Enum\Status;
use App\Messenger\Message\TicketSoldEmailMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

readonly class Sold implements StateInterface
{
    public function __construct(
        private Ticket $context,
    ) {
    }

    public function state(): Status
    {
        return Status::SOLD;
    }

    public function getContext(): StateableIntreface
    {
        return $this->context;
    }

    public function handle(): void
    {
        $this->context->setStatus(Status::SOLD->value);
    }

    public function writeHistory(): bool
    {
        return true;
    }

    public function notify(): bool
    {
        return true;
    }
}
