<?php

namespace App\State;

use App\Entity\StateableIntreface;
use App\Entity\TicketStateHistory;
use App\Messenger\Message\TicketSoldEmailMessage;

readonly class TicketStateMachine extends StateMachine
{
    protected function getConfig(): array
    {
        return $this->params->get('ticket_state_machine');
    }

    protected function writeState(StateInterface $state, StateableIntreface $originContext): void
    {
        $ticketHistory = new TicketStateHistory();
        $ticketHistory->setTickedId($state->getContext()->getId());
        $ticketHistory->setStatusFrom($originContext->getState()->state()->value);
        $ticketHistory->setStatusTo($state->state()->value);
        $ticketHistory->setCreatedAt(new \DateTime('now'));

        $this->entityManager->persist($ticketHistory);
        $this->entityManager->flush();
    }

    protected function notify(StateableIntreface $context): void
    {
        echo $context->getCode();

        $this->bus->dispatch(new TicketSoldEmailMessage($context->getCode()));
    }
}
