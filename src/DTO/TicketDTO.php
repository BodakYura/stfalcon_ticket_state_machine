<?php

namespace App\DTO;

class TicketDTO
{
    public function __construct(
        public int    $id,
        public string $code,
        public string $status,
    ) {
    }
}
