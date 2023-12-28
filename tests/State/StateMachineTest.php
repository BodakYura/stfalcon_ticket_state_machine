<?php

namespace App\Tests\State;

use App\Entity\Ticket;
use App\Enum\Status;
use App\State\Available;
use App\State\Lock;
use App\State\Sold;
use App\State\TicketStateMachine;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StateMachineTest extends WebTestCase
{
    private TicketStateMachine $stateMachine;

    public function setUp(): void
    {
        parent::setUp();

        $this->stateMachine = self::getContainer()->get(TicketStateMachine::class);
    }

    public function testCanChangeStateFromCreatedToAvailable(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::CREATED->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        $this->stateMachine->transitionTo(new Available($ticket));

        self::assertEquals(Status::AVAILABLE->value, $ticket->getState()->state()->value);
    }

    public function testCanChangeStateFromAvailableToLock(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::AVAILABLE->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        $this->stateMachine->transitionTo(new Lock($ticket));

        self::assertEquals(Status::LOCK->value, $ticket->getState()->state()->value);
    }

    public function testCanChangeStateFromLockToSold(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::LOCK->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        $this->stateMachine->transitionTo(new Sold($ticket));

        self::assertEquals(Status::SOLD->value, $ticket->getState()->state()->value);
    }

    public function testCanChangeStateFromSoldToAvailable(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::SOLD->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        $this->stateMachine->transitionTo(new Available($ticket));

        self::assertEquals(Status::AVAILABLE->value, $ticket->getState()->state()->value);
    }

    public function testCanChangeStateFromLockToAvailable(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::LOCK->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        $this->stateMachine->transitionTo(new Available($ticket));

        self::assertEquals(Status::AVAILABLE->value, $ticket->getState()->state()->value);
    }

    public function testCantChangeStateFromCreatedToLock(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::CREATED->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        self::expectException(\Exception::class);

        $this->stateMachine->transitionTo(new Lock($ticket));

        self::expectExceptionMessage(
            sprintf('Can\'t change status from "%s" to "%s"',
                Status::CREATED->value,
                $ticket->getState()->state()->value
            )
        );
    }

    public function testCantChangeStateFromSoldToLock(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::SOLD->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        self::expectException(\Exception::class);

        $this->stateMachine->transitionTo(new Lock($ticket));

        self::expectExceptionMessage(
            sprintf('Can\'t change status from "%s" to "%s"',
                Status::SOLD->value,
                $ticket->getState()->state()->value
            )
        );
    }

    public function testCantChangeStateFromCreatedToSold(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::SOLD->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        self::expectException(\Exception::class);

        $this->stateMachine->transitionTo(new Sold($ticket));

        self::expectExceptionMessage(
            sprintf('Can\'t change status from "%s" to "%s"',
                Status::CREATED->value,
                $ticket->getState()->state()->value
            )
        );
    }

    public function testCantChangeStateFromAvailableToSold(): void
    {
        $ticket = new Ticket();
        $ticket->setCode(mt_rand());
        $ticket->setStatus(Status::AVAILABLE->value);
        $ticket->setCreatedAt(new \DateTime());
        $ticket->setUpdatedAt(new \DateTime());

        self::expectException(\Exception::class);

        $this->stateMachine->transitionTo(new Sold($ticket));

        self::expectExceptionMessage(
            sprintf('Can\'t change status from "%s" to "%s"',
                Status::AVAILABLE->value,
                $ticket->getState()->state()->value
            )
        );
    }
}
