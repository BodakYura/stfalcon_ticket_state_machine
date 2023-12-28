<?php

namespace App\Controller;

use App\Service\TicketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ReturnTicketController extends AbstractController
{
    #[Route(
        '/return-ticket/{id}',
        name: 'return_ticket',
        methods: [
            Request::METHOD_GET,
        ]
    )]
    public function __invoke(Request $request, int $id, TicketService $ticketService): JsonResponse
    {
        $ticket = $ticketService->return($id);

        return $this->json(
            [
                'id' => $ticket->getId(),
                'code' => $ticket->getCode(),
                'status' => $ticket->getStatus(),
            ]
        );
    }
}
