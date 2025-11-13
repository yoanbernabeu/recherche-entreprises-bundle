<?php

namespace YoanBernabeu\RechercheEntreprisesBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use YoanBernabeu\RechercheEntreprisesBundle\Client\EntrepriseSearchClientInterface;

#[AsCommand(
    name: 'recherche-entreprise:search',
    description: 'Recherche des entreprises françaises',
)]
class SearchEntrepriseCommand extends Command
{
    public function __construct(
        private readonly EntrepriseSearchClientInterface $entrepriseClient
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('query', InputArgument::REQUIRED, 'Termes de recherche')
            ->addOption('siren', 's', InputOption::VALUE_NONE, 'Rechercher par SIREN')
            ->addOption('per-page', 'p', InputOption::VALUE_OPTIONAL, 'Résultats par page', 10)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $query = $input->getArgument('query');
        $isSiren = $input->getOption('siren');
        $perPage = (int) $input->getOption('per-page');

        try {
            if ($isSiren) {
                $entreprise = $this->entrepriseClient->findBySiren($query);
                
                if (!$entreprise) {
                    $io->warning('Aucune entreprise trouvée');
                    return Command::SUCCESS;
                }

                $io->success('Entreprise trouvée !');
                $io->definitionList(
                    ['SIREN' => $entreprise->siren],
                    ['Nom' => $entreprise->nomComplet],
                    ['Adresse' => $entreprise->siege?->adresse ?? 'N/A'],
                    ['Dirigeants' => implode(', ', $entreprise->dirigeants)],
                    ['Code NAF' => $entreprise->activitePrincipale ?? 'N/A'],
                    ['Actif' => $entreprise->isActif() ? '✅ Oui' : '❌ Non'],
                );
            } else {
                $result = $this->entrepriseClient->search($query, 1, $perPage);
                
                if (!$result->hasResults()) {
                    $io->warning('Aucun résultat trouvé');
                    return Command::SUCCESS;
                }

                $io->success(sprintf('%d résultat(s)', $result->totalResults));

                $rows = [];
                foreach ($result->results as $entreprise) {
                    $rows[] = [
                        $entreprise->siren,
                        substr($entreprise->nomComplet, 0, 40),
                        $entreprise->siege?->codePostal ?? 'N/A',
                        $entreprise->isActif() ? '✅' : '❌',
                    ];
                }

                $io->table(['SIREN', 'Nom', 'CP', 'Actif'], $rows);
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}