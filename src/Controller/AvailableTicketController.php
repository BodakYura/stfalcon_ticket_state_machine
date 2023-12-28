<?php

namespace App\Controller;

use App\Service\TicketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AvailableTicketController extends AbstractController
{
    #[Route(
        '/available-ticket/{id}',
        name: 'available_ticket',
        methods: [
            Request::METHOD_POST,
        ]
    )]
    public function __invoke(Request $request, int $id, TicketService $ticketService, SerializerInterface $serializer): JsonResponse
    {
        $ticket = $ticketService->available($id);

        return $this->json(
            [
                'id' => $ticket->getId(),
                'code' => $ticket->getCode(),
                'status' => $ticket->getStatus(),
            ],
        );
    }
}
