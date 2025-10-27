<?php

namespace YoanBernabeu\RechercheEntreprisesBundle\Client;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use YoanBernabeu\RechercheEntreprisesBundle\Model\Entreprise;
use YoanBernabeu\RechercheEntreprisesBundle\Model\SearchResult;

/**
 * Client pour interroger l'API Recherche d'entreprises.
 */
class EntrepriseSearchClient implements EntrepriseSearchClientInterface
{
    private const API_BASE_URL = 'https://recherche-entreprises.api.gouv.fr';
    private const MAX_PER_PAGE = 25;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ?LoggerInterface $logger = null,
        private readonly int $timeout = 10,
    ) {
    }

    public function search(
        string $query,
        int $page = 1,
        int $perPage = 10,
        array $filters = []
    ): SearchResult {
        $this->logger?->debug('Début de la recherche', ['query' => $query]);
        try {
            $params = array_merge([
                'q' => $query,
                'page' => max(1, $page),
                'per_page' => min($perPage, self::MAX_PER_PAGE),
            ], $filters);

            $response = $this->httpClient->request('GET', self::API_BASE_URL . '/search', [
                'query' => $params,
                'timeout' => $this->timeout,
            ]);

            $data = $response->toArray();

            $this->logger?->info('Recherche entreprise effectuée', [
                'query' => $query,
                'total_results' => $data['total_results'] ?? 0,
            ]);

            return SearchResult::fromArray($data);

        } catch (\Exception $e) {
            $this->logger?->error('Erreur lors de la recherche entreprise', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);
            throw new \RuntimeException(
                sprintf('Erreur lors de la recherche : %s', $e->getMessage()),
                0,
                $e
            );
        }
    }

    public function findBySiren(string $siren): ?Entreprise
    {
        $siren = preg_replace('/[^0-9]/', '', $siren);

        if (strlen($siren) !== 9) {
            throw new \InvalidArgumentException('Le SIREN doit contenir exactement 9 chiffres');
        }

        $result = $this->search($siren, 1, 1);

        if (!$result->hasResults()) {
            return null;
        }

        $entreprise = $result->getFirstResult();

        if ($entreprise && $entreprise->siren === $siren) {
            return $entreprise;
        }

        return null;
    }

    public function searchByCodePostal(
        string $codePostal,
        int $page = 1,
        int $perPage = 10
    ): SearchResult {
        return $this->search('', $page, $perPage, [
            'code_postal' => $codePostal,
        ]);
    }
}
