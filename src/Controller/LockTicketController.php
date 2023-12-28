<?php

namespace App\Controller;

use App\Service\TicketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LockTicketController extends AbstractController
{
    #[Route(
        '/lock-ticket/{id}',
        name: 'lock_ticket',
        methods: [
            Request::METHOD_GET,
        ]
    )]
    public function __invoke(Request $request, int $id, TicketService $ticketService): JsonResponse
    {
        $ticket = $ticketService->lock($id);

        return $this->json(
            [
                'id' => $ticket->getId(),
                'code' => $ticket->getCode(),
                'status' => $ticket->getStatus(),
            ],
        );
    }
}
