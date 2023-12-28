<?php

namespace App\Messenger\Message;

readonly class TicketSoldEmailMessage
{
    public function __construct(
        private int $code,
    ) {
    }

    public function getTickedCode(): int
    {
        return $this->code;
    }
}
