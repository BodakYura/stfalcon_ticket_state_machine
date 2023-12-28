<?php

namespace App\Controller;

use App\Service\TicketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateTicketController extends AbstractController
{
    #[Route(
        '/create-ticket/',
        name: 'create_ticket',
        methods: [
            Request::METHOD_POST,
        ]
    )]
    public function __invoke(Request $request, TicketService $ticketService, SerializerInterface $serializer): JsonResponse
    {
        $ticket = $ticketService->create();

        return $this->json(
            [
                'id' => $ticket->getId(),
                'code' => $ticket->getCode(),
                'status' => $ticket->getStatus(),
            ],
            201
        );
    }
}
