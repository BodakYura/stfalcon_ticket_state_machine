<?php

namespace App\Entity;

use App\Enum\Status;
use App\State\Available;
use App\State\Lock;
use App\State\Sold;
use App\State\StateInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'ticket_state_history')]
class TicketStateHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $tickedId;

    #[ORM\Column(type: 'string')]
    private string $statusFrom;

    #[ORM\Column(type: 'string')]
    private string $statusTo;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private \DateTime $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTickedId(): int
    {
        return $this->tickedId;
    }

    /**
     * @param int $tickedId
     */
    public function setTickedId(int $tickedId): void
    {
        $this->tickedId = $tickedId;
    }

    /**
     * @return string
     */
    public function getStatusFrom(): string
    {
        return $this->statusFrom;
    }

    /**
     * @param string $from
     */
    public function setStatusFrom(string $from): void
    {
        $this->statusFrom = $from;
    }

    /**
     * @return string
     */
    public function getStatusTo(): string
    {
        return $this->statusTo;
    }

    /**
     * @param string $to
     */
    public function setStatusTo(string $to): void
    {
        $this->statusTo = $to;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
