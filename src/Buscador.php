<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private ClientInterface $httpClient;
    private Crawler $crawler;
    
    
    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url) : array
    {
        $response = $this->httpClient->request('GET', $url);
        $html = $response->getBody();
        $this->crawler->addHtmlContent($html);
        $elements = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elements as $element) {
            $cursos[] = $element->textContent;
        }

        return $cursos;
    }
}