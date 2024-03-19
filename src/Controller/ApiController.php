<?php

namespace App\Controller;

use App\Infraestructure\Requests\ApiShortUrlRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/api/v1/short-url', name: 'shortUrl', methods: ['POST'])]
    public function shortUrl(ApiShortUrlRequest $request): JsonResponse
    {
        $request->validate();

        $response = json_decode($request->getRequest()->getContent());

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $this->getParameter('app.apishorturl').'?url='.$response->url);

        return $this->json([
            'url' => $response->getContent()
        ]);
    }
}
