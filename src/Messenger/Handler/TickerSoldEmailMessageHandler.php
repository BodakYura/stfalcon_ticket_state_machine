<?php

namespace App\Messenger\Handler;

use App\Messenger\Message\TicketSoldEmailMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TickerSoldEmailMessageHandler
{
    public function __invoke(TicketSoldEmailMessage $message): void
    {
        // send mail logic
    }
}
