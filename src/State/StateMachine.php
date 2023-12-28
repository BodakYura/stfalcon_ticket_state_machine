<?php

namespace App\State;

use App\Entity\StateableIntreface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\MessageBusInterface;

abstract readonly class StateMachine
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ParameterBagInterface $params,
        protected MessageBusInterface $bus
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function transitionTo(StateInterface $state): void
    {
        if (!$this->canBe($state)) {
            return;
        }

        $originContext = clone $state->getContext();

        $state->handle();

        $this->entityManager->persist($state->getContext());
        $this->entityManager->flush();

        if ($state->writeHistory()) {
            $this->writeState($state, $originContext);
        }

        if ($state->notify()) {
            $this->notify($state->getContext());
        }
    }

    /**
     * @throws \Exception
     */
    private function canBe(StateInterface $state): bool
    {
        $config = $this->getConfig();

        if (in_array($state->getContext()->getState()->state()->value,
                $config['states'][$state->state()->value]['from']) &&
            in_array($state->state()->value,
                $config['states'][$state->getContext()->getState()->state()->value]['to'])
        ) {
            return true;
        }

        throw new \Exception(
            sprintf('Can\'t change status from "%s" to "%s"',
                $state->getContext()->getState()->state()->value,
                $state->state()->value
            )
        );
    }

    abstract protected function getConfig(): array;

    abstract protected function writeState(StateInterface $state, StateableIntreface $originContext): void;

    abstract protected function notify(StateableIntreface $context): void;
}
