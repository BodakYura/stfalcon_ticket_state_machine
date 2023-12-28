<?php

namespace App\Service;

use App\Entity\Ticket;
use App\State\Available;
use App\State\Lock;
use App\State\Sold;
use App\State\TicketStateMachine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class TicketService
{
    public function __construct(
        private TicketStateMachine     $stateMachine,
        private EntityManagerInterface $entityManager,
        private MessageBusInterface    $bus
    ) {
    }

    public function create(): Ticket
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setCreatedAt(new \DateTime('now'));
        $ticket->setUpdatedAt(new \DateTime('now'));

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }

    public function available(int $ticketId): Ticket
    {
        $ticket = $this->entityManager->getRepository(Ticket::class)->find($ticketId);

        $this->stateMachine->transitionTo(new Available($ticket));

        return $ticket;
    }

    public function lock(int $ticketId): Ticket
    {
        $ticket = $this->entityManager->getRepository(Ticket::class)->find($ticketId);

        $this->stateMachine->transitionTo(new Lock($ticket));

        return $ticket;
    }

    public function sale(int $ticketId): Ticket
    {
        $ticket = $this->entityManager->getRepository(Ticket::class)->find($ticketId);

        $this->stateMachine->transitionTo(new Sold($ticket, $this->bus));

        return $ticket;
    }

    public function return(int $ticketId): Ticket
    {
        $ticket = $this->entityManager->getRepository(Ticket::class)->find($ticketId);

        $this->stateMachine->transitionTo(new Available($ticket));

        return $ticket;
    }
}
